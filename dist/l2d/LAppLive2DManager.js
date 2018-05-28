function LAppLive2DManager()
{
    // console.log("--> LAppLive2DManager()");
    
    // モデルデータ
    this.models = [];  // LAppModel
    
    //  サンプル機能
    this.count = -1;
    this.reloadFlg = false; // モデル再読み込みのフラグ
    
    Live2D.init();
    Live2DFramework.setPlatformManager(new PlatformManager);
    
}

LAppLive2DManager.prototype.createModel = function()
{
    // console.log("--> LAppLive2DManager.createModel()");
    
    var model = new LAppModel();
    this.models.push(model);
    
    return model;
}


LAppLive2DManager.prototype.changeModel = function(gl)
{
    // console.log("--> LAppLive2DManager.update(gl)");
    
    if (this.reloadFlg)
    {
        // モデル切り替えボタンが押された時、モデルを再読み込みする
        this.reloadFlg = false;
        var no = parseInt(this.count % 2);

        var thisRef = this;
		
		var select = document.getElementById("l2d_motion_sel");
		for(i = select.options.length - 1 ; i >= 1 ; i--){
			select.remove(i);
		}
		
        switch (no)
        {
            case 0: // ハル
                this.releaseModel(0, gl);
                // OpenGLのコンテキストをセット
                this.createModel();
                this.models[0].load(gl, l2d_basepath + jsonpath + "/normal/model.json", function() {
					var listmotion = this.live2DMgr.models[0].modelSetting.json.motions[""];
					for(var i = 0 ; i <= listmotion.length-1 ; i++) {
						var x = document.getElementById("l2d_motion_sel");
						var option = document.createElement("option");
						option.text = listmotion[i].file.slice(8).slice(0,-4);
						option.value = i;
						x.add(option);
					}
				});
				
                break;
            case 1: // しずく
                this.releaseModel(0, gl);
                this.createModel();
                this.models[0].load(gl, l2d_basepath + jsonpath + "/destroy/model.json", function() {
					var listmotion = this.live2DMgr.models[0].modelSetting.json.motions[""];
					for(var i = 0 ; i <= listmotion.length-1 ; i++) {
						var x = document.getElementById("l2d_motion_sel");
						var option = document.createElement("option");
						option.text = listmotion[i].file.slice(8).slice(0,-4);
						option.value = i;
						x.add(option);
					}
				});
                break;
            default:
                break;
        }
    }
};

LAppLive2DManager.prototype.changeMotion = function(no) {
	this.models[0].startMotion("", no, LAppDefine.PRIORITY_NORMAL);
}


LAppLive2DManager.prototype.getModel = function(no)
{
    // console.log("--> LAppLive2DManager.getModel(" + no + ")");
    
    if (no >= this.models.length) return null;
    
    return this.models[no];
};


LAppLive2DManager.prototype.getAllMotion = function()
{
	var result = "";
};


/*
 * モデルを解放する
 * ないときはなにもしない
 */
LAppLive2DManager.prototype.releaseModel = function(no, gl)
{
    // console.log("--> LAppLive2DManager.releaseModel(" + no + ")");
    
    if (this.models.length <= no) return;

    this.models[no].release(gl);
    
    delete this.models[no];
    this.models.splice(no, 1);
};


/*
 * モデルの数
 */
LAppLive2DManager.prototype.numModels = function()
{
    return this.models.length;
};


/*
 * ドラッグしたとき、その方向を向く設定する
 */
LAppLive2DManager.prototype.setDrag = function(x, y)
{
    for (var i = 0; i < this.models.length; i++)
    {
        this.models[i].setDrag(x, y);
    }
}


/*
 * 画面が最大になったときのイベント
 */
 /*
LAppLive2DManager.prototype.maxScaleEvent = function()
{
    if (LAppDefine.DEBUG_LOG)
        console.log("Max scale event.");
    for (var i = 0; i < this.models.length; i++)
    {
        this.models[i].startRandomMotion(LAppDefine.MOTION_GROUP_PINCH_IN,
                                         LAppDefine.PRIORITY_NORMAL);
    }
}
*/

/*
 * 画面が最小になったときのイベント
 */
 /*
LAppLive2DManager.prototype.minScaleEvent = function()
{
    if (LAppDefine.DEBUG_LOG)
        console.log("Min scale event.");
    for (var i = 0; i < this.models.length; i++)
    {
        this.models[i].startRandomMotion(LAppDefine.MOTION_GROUP_PINCH_OUT,
                                         LAppDefine.PRIORITY_NORMAL);
    }
}
*/

/*
 * タップしたときのイベント
 */
 /*
LAppLive2DManager.prototype.tapEvent = function(x, y)
{    
    if (LAppDefine.DEBUG_LOG)
        console.log("tapEvent view x:" + x + " y:" + y);

    for (var i = 0; i < this.models.length; i++)
    {

        if (this.models[i].hitTest(LAppDefine.HIT_AREA_HEAD, x, y))
        {
            // 顔をタップしたら表情切り替え
            if (LAppDefine.DEBUG_LOG)
                console.log("Tap face.");

            this.models[i].setRandomExpression();
        }
        else if (this.models[i].hitTest(LAppDefine.HIT_AREA_BODY, x, y))
        {
            // 体をタップしたらモーション
            if (LAppDefine.DEBUG_LOG)
                console.log("Tap body." + " models[" + i + "]");

            this.models[i].startRandomMotion(LAppDefine.MOTION_GROUP_TAP_BODY,
                                             LAppDefine.PRIORITY_NORMAL);
        }
    }

    return true;
};
*/
LAppLive2DManager.prototype.tapEvent = function(x, y)
{    
    if (LAppDefine.DEBUG_LOG)
        console.log("tapEvent view x:" + x + " y:" + y);

    for (var i = 0; i < this.models.length; i++)
    {
		/*
        if (this.models[i].hitTest(LAppDefine.HIT_AREA_BODY, x, y))
        {
            // 体をタップしたらモーション
            if (LAppDefine.DEBUG_LOG)
                console.log("Tap body." + " models[" + i + "]");

            this.models[i].startRandomMotion(LAppDefine.MOTION_GROUP_TAP_BODY,
                                             LAppDefine.PRIORITY_NORMAL);
        }
		*/
    }

    return true;
};