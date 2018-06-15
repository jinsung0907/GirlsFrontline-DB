//modified by Jinsung

function SkeletonBinary(){};

SkeletonBinary.prototype = {
    data : null,
    scale : 1,
    json : {},
    nextNum : 0,
    chars : null,
    readByte : function(){
        return this.nextNum < this.data.length ? this.data[this.nextNum++] : null;
    },
    readBoolean : function(){
        return this.readByte() != 0;
    },
    readShort : function(){
        return (this.readByte() << 8) | this.readByte();
    },
    readInt : function(optimizePositive){
        if(typeof optimizePositive === 'undefined'){
            return (this.readByte() << 24) | (this.readByte() << 16) | (this.readByte() << 8) | this.readByte();
        }
        var b = this.readByte();
        var result = b & 0x7f;
        if ((b & 0x80) != 0){
            b = this.readByte();
            result |= (b & 0x7F) << 7;
            if ((b & 0x80) != 0){
                b = this.readByte();
                result |= (b & 0x7F) << 14;
                if ((b & 0x80) != 0){
                    b = this.readByte();
                    result |= (b & 0x7F) << 21;
                    if ((b & 0x80) != 0){
                        b = this.readByte();
                        result |= (b & 0x7F) << 28;
                    }
                }
            }
        }
        return optimizePositive ? result : ((result >> 1) ^ -(result & 1));
    },
    bytes2Float32 : function(bytes){
        var sign = (bytes & 0x80000000) ? -1 : 1;
        var exponent = ((bytes >> 23) & 0xFF) - 127;
        var significand = (bytes & ~(-1 << 23));

        if (exponent == 128)
            return sign * ((significand) ? Number.NaN : Number.POSITIVE_INFINITY);

        if (exponent == -127) {
            if (significand == 0) return sign * 0.0;
            exponent = -126;
            significand /= (1 << 22);
        } else significand = (significand | (1 << 23)) / (1 << 23);

        return sign * significand * Math.pow(2, exponent);
    },
    readFloat : function(){
        return this.bytes2Float32((this.readByte()<<24) + (this.readByte()<<16) + (this.readByte()<<8) + (this.readByte()<<0));
    },
    readFloatArray : function(){
        var n = this.readInt(true);
        var array = new Array(n);
        if(this.scale == 1){
            for(var i = 0; i < n; i++){
                array[i] = this.readFloat();
            }
        }else{
            for(var i = 0; i < n; i++){
                array[i] = this.readFloat() * this.scale;
            }
        }
        return array;
    },
    readShortArray : function(){
        var n = this.readInt(true);
        var array = new Array(n);
        for(var i = 0; i < n; i++){
            array[i] = this.readShort();
        }
        return array;
    },
    readIntArray : function(){
        var n = this.readInt(true);
        var array = new Array(n);
        for(var i = 0; i < n; i++)
            array[i] = this.readInt(true);
        return array;
    },
    readHex : function(){
        var hex = this.readByte().toString(16);
        return hex.length == 2 ? hex : '0' + hex;
    },
    readColor : function(){
        return this.readHex() + this.readHex() + this.readHex() + this.readHex();
    },
    readUtf8_slow : function(charCount, charIndex, b){
        while(true){
            switch (b >> 4){
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
                this.chars += String.fromCharCode(b);
                break;
            case 12:
            case 13:
                this.chars += String.fromCharCode((b & 0x1F) << 6 | this.readByte() & 0x3F);
                break;
            case 14:
                this.chars += String.fromCharCode((b & 0x0F) << 12 | (this.readByte() & 0x3F) << 6 | this.readByte() & 0x3F);
                break;
            }
            if (++charIndex >= charCount) break;
            b = this.readByte() & 0xFF;
        }
    },
    readString(){
        var charCount = this.readInt(this, true);
        switch(charCount){
        case 0:
            return null;
        case 1:
            return "";
        }
        charCount--;
        this.chars = "";
        var b = 0;
        var charIndex = 0;
        while (charIndex < charCount){
            b = this.readByte();
            if (b > 127)
                break;
            this.chars += String.fromCharCode(b);
            charIndex++;
        }
        if (charIndex < charCount)
            this.readUtf8_slow(charCount, charIndex, b);
        return this.chars;
    },
    initJson : function(){
        this.json.skeleton = {};
        var skeleton = this.json.skeleton;
        skeleton.hash = this.readString();
        if(skeleton.hash.length == 0)
            skeleton.hash = null;
        skeleton.spine = this.readString();
        if(skeleton.spine.length == 0)
            skeleton.spine = null;
        skeleton.width = this.readFloat();
        skeleton.height = this.readFloat();
        var nonessential = this.readBoolean();
        if(nonessential){
            skeleton.images = this.readString();
            if(skeleton.images.length == 0)
                skeleton.images = null;
        }

        //Bones.
        this.json.bones = new Array(this.readInt(true));
        var bones = this.json.bones;
        for(var i = 0; i < bones.length; i++){
            var boneData = {};
            boneData.name = this.readString();
            boneData.parent = null;
            var parentIndex = this.readInt(true) - 1;
            if(parentIndex != -1)
                boneData.parent = bones[parentIndex].name;
            boneData.x = this.readFloat() * this.scale;
            boneData.y = this.readFloat() * this.scale;
            boneData.scaleX = this.readFloat();
            boneData.scaleY = this.readFloat();
            boneData.rotation = this.readFloat();
            boneData.length = this.readFloat() * this.scale;
            boneData.flipX = this.readBoolean();
            boneData.flipY = this.readBoolean();
            boneData.inheritScale = this.readBoolean();
            boneData.inheritRotation = this.readBoolean();

            if(nonessential){
                boneData.color = this.readColor();
            }
            bones[i] = boneData;
        }

        // IK constraints.
        var ikIndex = this.readInt(true);
        if(ikIndex > 0){
            this.json.ik = new Array(this.readInt(true));
            var ik = this.json.ik;
            for(var i = 0; i < ikIndex; i++){
                var ikConstraints = {};
                ikConstraints.name = this.readString();
                ikConstraints.bones = new Array(this.readInt(true));
                for(var j = 0; j < ikConstraints.bones.length; j++){
                    ikConstraints.bones[j] = this.json.bones[this.readInt(true)].name;
                }
                ikConstraints.target = this.json.bones[this.readInt(true)].name;
                ikConstraints.mix = this.readFloat();
                ikConstraints.bendPositive = this.readBoolean();
                // Maybe use ReadSByte();
                ik[i] = ikConstraints;
            }
        }

        // Slots.
        this.json.slots = new Array(this.readInt(true));
        var slots = this.json.slots;
        for(var i = 0; i < slots.length; i++){
            var slotData = {};
            slotData.name = this.readString();
            var boneData = this.json.bones[this.readInt(true)];
            slotData.bone = boneData.name;
            slotData.color = this.readColor();
            slotData.attachment = this.readString();
            slotData.blend = BlendMode[this.readInt(true)];
            slots[i] = slotData;
        }
		
        // Default skin.
        this.json.skins = {};
        this.json.skinsName = new Array();
        var skins = this.json.skins;
        var defaultSkin = this.readSkin("default", nonessential);
        if(defaultSkin != null){
            skins["default"] = defaultSkin;
            this.json.skinsName.push("default");
        }

        // Skin.
        for(var i = 0, n = this.readInt(true); i < n; i++){
            var skinName = this.readString();
            var skin = this.readSkin(skinName, nonessential);
            skins[skinName] = skin;
            this.json.skinsName.push("skinName");
        }

        // Events.
        this.json.events = [];
        this.json.eventsName = [];
        var events = this.json.events;
        for(var i = 0, n = this.readInt(true); i < n; i++){
            var eventName = this.readString();
            var event = {};
            event.int = this.readInt(false);
            event.float = this.readFloat();
            event.string = this.readString();
            events[eventName] = event;
            this.json.eventsName[i] = eventName;
        }

        // Animations.
        this.json.animations = {};
        var animations = this.json.animations;
        for(var i = 0, n = this.readInt(true); i < n; i++){
            var animationName = this.readString();
            var animation = this.readAnimation(animationName);
            animations[animationName] = animation;
        }
		

    },
    readSkin(skinName, nonessential){
        var slotCount = this.readInt(true);
        if(slotCount == 0)
            return null;
        var skin = {};
        for(var i = 0; i < slotCount; i++){
            var slotIndex = this.readInt(true);
            var slot = {};
            for(var j = 0, n = this.readInt(true); j < n; j++){
                var name = this.readString();
                var attachment = this.readAttachment(name, nonessential);
                slot[name] = attachment;
            }
            skin[this.json.slots[slotIndex].name] = slot;
        }
        return skin;
    },
    readAttachment(attachmentName, nonessential){
        var name = this.readString();
        if(name == null)
            name = attachmentName;
        switch(AttachmentType[this.readByte()]){
        case "region":
            var path = this.readString();
            if(path == null)
                path = name;
            var region = {};
            region.type = "region";
            region.name = name;
            region.path = path;
            region.x = this.readFloat() * this.scale;
            region.y = this.readFloat() * this.scale;
            region.scaleX = this.readFloat();
            region.scaleY = this.readFloat();
            region.rotation = this.readFloat();
            region.width = this.readFloat() * this.scale;
            region.height = this.readFloat() * this.scale;
            region.color = this.readColor();
            // Maybe need UpdateOffset()
            return region;
        case "boundingbox":
            var box = {};
            box.type = "boundingbox";
            box.name = name;
            box.vertices = this.readFloatArray();
            // Maybe need vertexCount or color
            return box;
        case "mesh":
            var path = this.readString();
            if(path == null)
                path = name;
            var mesh = {};
            mesh.type = "mesh";
            mesh.name = name;
            mesh.path = path;
            mesh.uvs = this.readFloatArray();
            // Maybe need updateUVs()
            mesh.triangles = this.readShortArray();
            mesh.vertices = this.readFloatArray();
            mesh.color = this.readColor();
            mesh.hull = this.readInt(true);
            // Maybe need * 2
            if(nonessential){
                mesh.edges = this.readIntArray();
                mesh.width = this.readFloat();
                mesh.height = this.readFloat();
                // Maybe need * scale
            }
            return mesh;
        case "skinnedmesh":
            var path = this.readString();
            if(path == null)
                path = name;
            var skinnedmesh = {};
            skinnedmesh.type = "skinnedmesh";
            skinnedmesh.name = name;
            skinnedmesh.path = path;
            skinnedmesh.uvs = this.readFloatArray();
            skinnedmesh.triangles = this.readShortArray();

            skinnedmesh.vertices = new Array();
            var vertexCount = this.readInt(true);
            for(var i = 0; i < vertexCount;){
                var boneCount = Math.floor(this.readFloat());
                skinnedmesh.vertices[i++] = boneCount;
                for(var nn = i + boneCount * 4; i < nn; i += 4){
                    skinnedmesh.vertices[i] = Math.floor(this.readFloat());
                    skinnedmesh.vertices[i + 1] = this.readFloat();
                    skinnedmesh.vertices[i + 2] = this.readFloat();
                    skinnedmesh.vertices[i + 3] = this.readFloat();
                }
            }
            skinnedmesh.color = this.readColor();
            skinnedmesh.hull = this.readInt(true);
            // Maybe need * 2
            if(nonessential){
                skinnedmesh.edges = this.readIntArray();
                skinnedmesh.width = this.readFloat();
                skinnedmesh.height = this.readFloat();
                // Maybe need * scale
            }
            return skinnedmesh;
        }
        return null;
    },
    readCurve(frameIndex, timeline){
        switch(this.readByte()){
        case 1: //CURVE_STEPPED
            timeline[frameIndex].curve = "stepped";
            break;
        case 2: //CURVE_BEZIER
            var cx1 = this.readFloat();
            var cy1 = this.readFloat();
            var cx2 = this.readFloat();
            var cy2 = this.readFloat();
            timeline[frameIndex].curve = [cx1, cy1, cx2, cy2];
        }
    },
    readAnimation(name){
        var animation = {};
        var scale = this.scale;
        var duration = 0;

        // Slot timelines.
        var slots = {};
        for(var i = 0, n = this.readInt(true); i < n; i++){
            var slotIndex = this.readInt(true);
            var slotMap = {};
            var timeCount = this.readInt(true);
            for(var ii = 0; ii < timeCount; ii++){
                var timelineType = this.readByte();
                var frameCount = this.readInt(true);
                switch(timelineType){
                case 4: //TIMELINE_COLOR
                    var timeline = new Array(frameCount);
                    for(var frameIndex = 0; frameIndex < frameCount; frameIndex++){
                        var time = this.readFloat();
                        var color = this.readColor();
                        timeline[frameIndex] = {};
                        timeline[frameIndex].time = time;
                        timeline[frameIndex].color = color;
                        if(frameIndex < frameCount - 1){
                            var str = this.readCurve(frameIndex, timeline);
                        }
                    }
                    slotMap.color = timeline;
                    duration = Math.max(duration, timeline[frameCount - 1].time);
                    break;
                case 3: //TIMELINE_ATTACHMENT
                    var timeline = new Array(frameCount);
                    for(var frameIndex = 0; frameIndex < frameCount; frameIndex++){
                        var time = this.readFloat();
                        var attachmentName = this.readString();
                        timeline[frameIndex] = {};
                        timeline[frameIndex].time = time;
                        timeline[frameIndex].name = attachmentName;
                    }
                    slotMap.attachment = timeline;
                    duration = Math.max(duration, timeline[frameCount - 1].time);
                    break;
                }
            }
            slots[this.json.slots[slotIndex].name] = slotMap;
        }
        animation.slots = slots;

        //// Bone timelines.
        var bones = {};
        for(var i = 0, n = this.readInt(true); i < n; i++){
            var boneIndex = this.readInt(true);
            var boneMap = {};
            for(var ii = 0, nn = this.readInt(true); ii < nn; ii++){
                var timelineType = this.readByte();
                var frameCount = this.readInt(true);
                switch(timelineType){
                case 1: //TIMELINE_ROTATE
                    var timeline = new Array(frameCount);
                    for(var frameIndex = 0; frameIndex < frameCount; frameIndex++){
                        var tltime = this.readFloat();
                        var tlangle = this.readFloat();
                        timeline[frameIndex] = {};
                        timeline[frameIndex].time = tltime;
                        timeline[frameIndex].angle = tlangle;
                        if(frameIndex < frameCount - 1){
                            this.readCurve(frameIndex, timeline);
                        }
                    }
                    boneMap.rotate = timeline;
                    duration = Math.max(duration, timeline[frameCount - 1].time);
                    break;
                case 2: //TIMELINE_TRANSLATE
                case 0: //TIMELINE_SCALE
                    var timeline = new Array(frameCount);
                    var timelineScale = 1;
                    if(timelineType == 2){
                        timelineScale = scale;
                    }
                    for(var frameIndex = 0; frameIndex < frameCount; frameIndex++){
                        var tltime = this.readFloat();
                        var tlx = this.readFloat();
                        var tly = this.readFloat();
                        timeline[frameIndex] = {};
                        timeline[frameIndex].time = tltime;
                        timeline[frameIndex].x = tlx;
                        timeline[frameIndex].y = tly;
                        if(frameIndex < frameCount - 1){
                            this.readCurve(frameIndex, timeline);
                        }
                    }
                    if(timelineType == 0){
                        boneMap.scale = timeline;
                    }else{
                        boneMap.translate = timeline;
                    }
                    duration = Math.max(duration, timeline[frameCount - 1].time);
                    break;
                case 5: //TIMELINE_FLIPX
                case 6: //TIMELINE_FLIPY
                    var timeline = new Array(frameCount);
                    for(var frameIndex = 0; frameIndex < frameCount; frameIndex++){
                        var tltime = this.readFloat();
                        var tlflip = this.readBoolean();
                        timeline[frameIndex] = {};
                        timeline[frameIndex].time = tltime;
                        if(timelineType == 5)
                            timeline[frameIndex].x = tlflip;
                        else
                            timeline[frameIndex].y = tlflip;
                    }
                    if(timelineType == 5)
                        boneMap.flipX = timeline;
                    else
                        boneMap.flipY = timeline;
                    duration = Math.max(duration, timeline[frameCount - 1].time);
                    break;
                }
            }
            bones[this.json.bones[boneIndex].name] = boneMap;
        }
        animation.bones = bones;

        // IK timelines.
        var ik = {};
        for(var i = 0, n = this.readInt(true); i < n; i++){
            var ikIndex = this.readInt(true);
            var frameCount = this.readInt(true);
            var timeline = new Array(frameCount);
            for(var frameIndex = 0; frameIndex < frameCount; frameIndex++){
                var time = this.readFloat();
                var mix = this.readFloat();
                var bendPositive = this.readBoolean();
                // Maybe use ReadSByte()
                timeline[frameIndex].time = time;
                timeline[frameIndex].mix = mix;
                timeline[frameIndex].bendPositive = bendPositive;
                if(frameIndex < frameCount - 1)
                    this.readCurve(frameIndex, timeline);
            }
            ik[this.json.ik[ikIndex]] = timeline;
        }
        animation.ik = ik;

        // FFD timelines.
        var ffd = {};
        for(var i = 0, n = this.readInt(true); i < n; i++){
            var skinIndex = this.readInt(true);
            var slotMap = {};
            for(var ii = 0, nn = this.readInt(true); ii < nn; ii++){
                var slotIndex = this.readInt(true);
                var meshMap = {};
                for(var iii = 0, nnn = this.readInt(true); iii < nnn; iii++){
                    var meshName = this.readString();
                    var frameCount = this.readInt(true);
                    var attachment;
                    var attachments = this.json.skins[this.json.skinsName[skinIndex]][this.json.slots[slotIndex].name];
                    for(var attachmentName in attachments){
                        if(attachments[attachmentName].name == meshName)
                            attachment = attachments[attachmentName];
                    }
                    if(!attachment)
                        console.log("FFD attachment not found: " + meshName);
                    var timeline = new Array(frameCount);
                    for(var frameIndex = 0; frameIndex < frameCount; frameIndex++){
                        var time = this.readFloat();
                        var vertexCount;
                        if(attachment.type == "mesh"){
                            vertexCount = attachment.vertices.length;
                        }else{
                            vertexCount = attachment.uvs.length * 3 * 3;
                            // This maybe wrong
                        }

                        var vertices = new Array(vertexCount);
                        for (var verticeIdx = 0; verticeIdx < vertexCount; verticeIdx++){
                          vertices[verticeIdx] = 0.0;
                        }

                        // ToDo: I have no idea why we need this
                        var bugFixMultiplicator = 0.1;

                        var end = this.readInt(true);
                        if (end == 0) {
                          if (attachment.type == "mesh") {
                            for (var verticeIdx = 0; verticeIdx < vertexCount; verticeIdx++){
                              vertices[verticeIdx] += attachment.vertices[verticeIdx] * bugFixMultiplicator;
                            }
                          }
                        } else {
                            var start = this.readInt(true);
                            end += start;

                            for(var v = start; v < end; v++){
                                vertices[v] = this.readFloat() * scale;
                            }

                            if(attachment.type == "mesh"){
                                var meshVertices = attachment.vertices;
                                for(var v = 0, vn = vertices.length; v < vn; v++){
                                    vertices[v] += meshVertices[v] * bugFixMultiplicator;
                                }
                            }
                        }
                        timeline[frameIndex] = {};
                        timeline[frameIndex].time = time;
                        timeline[frameIndex].vertices = vertices;
                        if(frameIndex < frameCount - 1)
                            this.readCurve(frameIndex, timeline);
                    }
                    meshMap[meshName] = timeline;
                    duration = Math.max(duration, timeline[frameCount - 1].time);
                }
                slotMap[this.json.slots[slotIndex].name] = meshMap;
            }
            ffd[this.json.skinsName[skinIndex]] = slotMap;
        }
        animation.ffd = ffd;

        // Draw order timeline.
        var drawOrderCount = this.readInt(true);
        if(drawOrderCount > 0){
            var drawOrders = new Array(drawOrderCount);
            // var timeline = new Array(drawOrderCount);
            var slotCount = this.json.slots.length;
            for(var i = 0; i < drawOrderCount; i++){
                var drawOrderMap = {};
                var offsetCount = this.readInt(true);
                // var drawOrder = new Array(slotCount);
                // for(var ii = slotCount - 1; ii >= 0; ii--){
                //     drawOrder[ii] = -1;
                // }
                // var unchanged = new Array(slotCount - offsetCount);
                // var originalIndex = 0, unchangedIndex = 0;
                var offsets = new Array(offsetCount);
                for(var ii = 0; ii < offsetCount; ii++){
                    var offsetMap = {};
                    var slotIndex = this.readInt(true);
                    offsetMap.slot = this.json.slots[slotIndex].name;
                    // while (originalIndex != slotIndex)
                    //     unchanged[unchangedIndex++] = originalIndex++;
                    var dooffset = this.readInt(true);
                    offsetMap.offset = dooffset;
                    // drawOrder[originalIndex + dooffset] = originalIndex++;
                    offsets[ii] = offsetMap;
                }
                drawOrderMap.offsets = offsets;

                // while(originalIndex < slotCount)
                //     unchanged[unchangedIndex++] = originalIndex++;
                // for (var ii = slotCount - 1; ii >= 0; ii--){
                //     if (drawOrder[ii] == -1)
                //         drawOrder[ii] = unchanged[--unchangedIndex];
                var tltime = this.readFloat();
                drawOrderMap.time = tltime;
                drawOrders[i] = drawOrderMap;
            }
            duration = Math.max(duration, drawOrders[drawOrderCount - 1].time);
            animation.drawOrder = drawOrders;
        }

        // Event timeline.
        var eventCount = this.readInt(true);
        if(eventCount > 0){
            var events = new Array(eventCount);
            for(var i = 0; i < eventCount; i++){
                var time = this.readFloat();
                var name = this.json.eventsName[this.readInt(true)];
                var eventData = this.json.events[name];
                var e = {};
                e.name = name;
                e.int = this.readInt(true);
                e.float = this.readFloat();
                e.string = this.readBoolean() ? this.readString() : eventData.string;
                e.time = time;
                events[i] = e;
            }
            duration = Math.max(duration, events[eventCount - 1].time);
            animation.events = events;
        }
        return animation;
    }
}
var BlendMode = ["normal", "additive", "multiply", "screen"];
var AttachmentType = ["region", "boundingbox", "mesh", "skinnedmesh"];


var jspine = {
	init : function(SDname, skin){
		if(typeof skin === 'undefined' || skin == 0) {
			skin = '';
		}
		jspine.spine;
		jspine.canvas = $(".preCanvas");
		jspine.stage = new PIXI.Container;
		jspine.renderer = PIXI.autoDetectRenderer(jspine.canvas.width(), jspine.canvas.height(), {transparent : true});
		jspine.lastTime = new Date().getTime();
		jspine.nowTime = new Date().getTime();
		jspine.animationFrame = window.requestAnimationFrame(jspine.animate);
		jspine.isUpdate = true;
		jspine.spineData = {};
		jspine.curAniIndex;
		
		jspine.renderer.plugins.interaction.autoPreventDefault = false;
		
		jspine.load(SDname, skin);
		
		jspine.canvas.html(jspine.renderer.view);
		
	},
	load : function(SDname, skinnum, is_r) {
		if(typeof skinnum === 'undefined' || skin == 0) {
			skinnum = '';
		}
		var name = SDname;
		var baseName = SDname;
		
		var dorm = '';
		console.log(is_r);
		if(skinnum !== '') {
			if(typeof is_r !== 'undefined' && is_r[2]) dorm = "r"; else dorm = "";
			var skelpath = SDname + "_" + skinnum + "/spine/" + dorm + SDname + "_" + skinnum + ".skel";
			if(typeof is_r !== 'undefined' && is_r[0]) dorm = "r"; else dorm = "";
			var atlaspath = SDname + "_" + skinnum + "/spine/" + dorm + SDname + "_" + skinnum + ".atlas";
			if(typeof is_r !== 'undefined' && is_r[0]) dorm = "r"; else dorm = "";
			var pngpath = SDname + "_" + skinnum + "/spine/" + dorm + SDname + "_" + skinnum + ".png";
		} else {
			if(typeof is_r !== 'undefined' && is_r[2]) dorm = "r"; else dorm = "";
			var skelpath = SDname + "/spine/" + dorm + SDname + ".skel";
			if(typeof is_r !== 'undefined' && is_r[0]) dorm = "r"; else dorm = "";
			var atlaspath = SDname + "/spine/" + dorm + SDname  + ".atlas";
			if(typeof is_r !== 'undefined' && is_r[0]) dorm = "r"; else dorm = "";
			var pngpath = SDname + "/spine/" + dorm + SDname + ".png";
		}
		var skin = "default";
		var basePath = "img/characters/";

		

		var loader = new PIXI.loaders.Loader(basePath);

		jspine.selectScale = 0.8;
		jspine.selectX = jspine.canvas.width()/2;
		jspine.selectY = jspine.canvas.height()-40;
			
		loader.add(baseName + "-skel", skelpath, { "xhrType" : "arraybuffer", "metadata" : { "type" : "skel", "name" : name, "skin" : skin } });
		loader.add(baseName + "-atlas", atlaspath, { "metadata" : { "type" : "atlas" } });
		loader.add(baseName + "-png", pngpath, { "metadata" : { "type" : "png" } });
		loader.on('progress', function () {
			console.log('loading...');
		});

		loader.load((loader, resources) => {
			loader.next = baseName;
			var rawSkeletonData, rawAtlasData, rawPngData;
			var skel = new SkeletonBinary();
			jspine.name = resources[loader.next + "-skel"].metadata.name;
			jspine.skin = resources[loader.next + "-skel"].metadata.skin;
			skel.data = new Uint8Array(resources[loader.next + "-skel"].data);
			skel.initJson();
			rawSkeletonData = skel.json;

			rawAtlasData = resources[loader.next + "-atlas"].data;
			rawPngData = resources[loader.next + "-png"].data;

			var spineAtlas = new PIXI.spine.SpineRuntime.Atlas(rawAtlasData, function(line, callback, pngData = rawPngData) {
				callback(new PIXI.BaseTexture(pngData));
			});
			
			var spineAtlasParser = new PIXI.spine.SpineRuntime.AtlasAttachmentParser(spineAtlas);
			var spineJsonParser = new PIXI.spine.SpineRuntime.SkeletonJsonParser(spineAtlasParser);
			var skeletonData = spineJsonParser.readSkeletonData(rawSkeletonData, skin);
			skeletonData.code = name;
			skeletonData.skin = skin;

			jspine.spineData[name] = jspine.spineData[name] || {};
			jspine.spineData[name][skin] = skeletonData;
			jspine.changeCanvas(skeletonData);
		});
	},
	changeCanvas : function(skeletonData){
		jspine.stage.removeChildren();
		jspine.name = skeletonData.name;
		jspine.skeletonData = skeletonData;
		jspine.spine = new PIXI.spine.Spine(skeletonData);
		jspine.spine.x = jspine.selectX;
		jspine.spine.y = jspine.selectY;
		jspine.spine.scale.x = jspine.selectScale;
		jspine.spine.scale.y = jspine.selectScale;
		
		var animations = jspine.spine.spineData.animations;
		$("#sdAniSelector").empty();
		for(var i = 0 ; i <= animations.length-1 ; i++) {
			if(animations[i].name !== 'victoryloop') {
				$("#sdAniSelector").append($('<option>', {
					value: i,
					text: animations[i].name
				}));
			}
			if(animations[i].name == 'wait') {
				jspine.curAniIndex = i;
			}
		}
		$("#sdAniSelector").val(jspine.curAniIndex);
		
		jspine.changeAnimation(jspine.curAniIndex);
		jspine.spine.skeleton.setToSetupPose();
		jspine.spine.update(0);
		jspine.spine.autoUpdate = false;
		jspine.stage.addChild(jspine.spine);
		
		jspine.spine.state.onComplete = function(trackIndex) { 
			if(jspine.spine.spineData.animations[jspine.curAniIndex].name == "victory") {
				var cnt = 0;
				for(var i = 0 ; i <= animations.length-1 ; i++) {
					if(animations[i].name == 'victoryloop') {
						jspine.changeAnimation(i);
						cnt++;
					}
				}
				if(cnt == 0) 
					jspine.changeAnimation(jspine.curAniIndex);
			}
		}
		
	},
	
	loadToStage : function(defaultStageData, spineData){
		for (i in defaultStageData) {
		  var role = defaultStageData[i];
		  var spine = spineData[role.name][role.skin];
			  spine.code = role.name;
			  spine.skin = role.skin;
			  spine.x = role.x;
			  spine.y = role.y;
			  spine.scale = role.scale;
			  spine.animation = role.animation;
		}
	},
	
	animate : function(){
		jspine.lastTime = jspine.nowTime;
		jspine.nowTime = new Date().getTime();
		jspine.animationFrame = window.requestAnimationFrame(jspine.animate);
		if(jspine.isUpdate && jspine.spine) {
			jspine.spine.update( (jspine.nowTime - jspine.lastTime) / 1000 );
		} 
		jspine.renderer.render(jspine.stage);
	},
	
	changeAnimation : function(num){
		var name = jspine.spine.spineData.animations[num].name;
		var isload = true;
		if(name == "die" || name == "reload" || name == "victory")
			isload = false;
		jspine.spine.state.setAnimationByName(0, name, isload, 0);
		jspine.spine.update(0);
		jspine.curAniIndex = num;
	}
}