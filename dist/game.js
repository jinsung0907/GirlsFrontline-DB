$(document).ready(function(){
  game.init();
});

if (typeof resPasePath === 'undefined') {
  var resPasePath = '';
}

var game = {
  init : function(){
    game.girls = new Girls(resPasePath + "character/");
    game.background = ["Airport", "Bridge", "Forest", "IceLake", "Sonw", "Street"];
    preview.init();
    gameview.init();
    var stageLoaded = false;
    if (typeof defaultStageData !== 'undefined') {
      preview.loadStage(defaultStageData);
      stageLoaded = true;
    }
    if (window.location.hash && stageLoaded==false) {
      var hash = window.location.hash.substring(1);
      preview.loadStage(hash);
      stageLoaded = true;
    }
    if (stageLoaded==false) {
      gameview.selectBackground.val('Airport').change();
    }
  },

  setGameviewHandler : function(handler){
    gameview.handler = handler;
  }
};

var preview = {
  init : function(){
    preview.canvas = $(".preCanvas");
    preview.selectCharacter = $(".preSelectCharacter > select");
    preview.selectSkin = $(".preSelectSkin > select");
    preview.selectAnimation = $(".preSelectAnimation > select");
    preview.stopRole = $(".preStopRole");
    preview.addRole = $(".preAddRole");
    preview.isUpdate = true;

    var stringCharacter = "<option>請選擇</option>";
    for (var type in girlsOptions) {
      stringCharacter+= '<optgroup label="' + type + '">';
      for (var name in girlsOptions[type]) {
        var optionName = (girlsDataTw[name]) ? girlsDataTw[name].name : name;
        stringCharacter+= '<option value="' + name + '">' + optionName + '</option>';
      }
      stringCharacter+= '</optgroup>';
    }
    preview.selectCharacter.html(stringCharacter);
    preview.selectCharacter.change(function(){
      if(this.selectedIndex == 0)
        return;
      var name = $(this).val();
      var type = $(':selected', this).parent().attr('label');
      var strSkinsOption = "";
      if (!girlsData[name]) {
        return;
      }
      for (var skin in girlsData[name]) {
        strSkinsOption += "<option value=\"" + skin + "\">" + skin + "</option>";
      }
      preview.selectSkin.html(strSkinsOption);
      preview.selectSkin.change();
    });

    preview.selectSkin.change(function(){
      game.girls.load(preview.selectCharacter.val(), preview.selectSkin.val(), preview);
    });

    preview.selectAnimation.change(function(){
      preview.changeAnimation(this.selectedIndex);
    });

    preview.addRole.click(function(){
      if (preview.skeletonData) {
        gameview.addRole(preview.skeletonData, preview.selectAnimation.val());
      }
    });

    preview.stopRole.click(function(){
      if(preview.isUpdate){
        preview.isUpdate = false;
        preview.stopRole.html("開始");
      }else{
        preview.isUpdate = true;
        preview.stopRole.html("停止");
      }
    });

    preview.selectScale = 1;
    preview.selectX = 128;
    preview.selectY = 180;

    preview.stage = new PIXI.Container;
    preview.renderer = PIXI.autoDetectRenderer(preview.canvas.width(), preview.canvas.height(), {transparent : true});
    preview.lastTime = new Date().getTime();
    preview.nowTime = new Date().getTime();
    preview.animationFrame = window.requestAnimationFrame(preview.animate);
    preview.canvas.html(preview.renderer.view);
  },

  changeCanvas : function(skeletonData){
    preview.stage.removeChildren();
    preview.name = skeletonData.name;
    preview.skeletonData = skeletonData;
    preview.spine = new PIXI.spine.Spine(skeletonData);
        preview.spine.x = preview.selectX;
        preview.spine.y = preview.selectY;
        preview.spine.scale.x = preview.selectScale;
    preview.spine.scale.y = preview.selectScale;
    var animations = preview.spine.spineData.animations;
    var stringAnimations = "";
    for(var i = 0; i < animations.length; i++){
      stringAnimations += "<option value=\"" + animations[i].name + "\">" + animations[i].name + "</option>";
    }
    preview.selectAnimation.html(stringAnimations);
    preview.changeAnimation(0);
    preview.spine.skeleton.setToSetupPose();
    preview.spine.update(0);
    preview.spine.autoUpdate = false;
    preview.stage.addChild(preview.spine);
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
      gameview.addRole(spine, role.animation);
    }
  },

  animate : function(){
    preview.lastTime = preview.nowTime;
    preview.nowTime = new Date().getTime();
    preview.animationFrame = window.requestAnimationFrame(preview.animate);
    if(preview.isUpdate && preview.spine)
      preview.spine.update( (preview.nowTime - preview.lastTime) / 1000 );
    preview.renderer.render(preview.stage);
  },

  changeAnimation : function(num){
    var name = preview.spine.spineData.animations[num].name;
    var isload = true;
    if(name == "die" || name == "reload" || name == "victory")
      isload = false;
    preview.spine.state.setAnimationByName(0, name, isload, 0);
    preview.spine.update(0);
  },

  loadStage : function(jsonString)
  {
    var defaultStageData = JSON.parse(decodeURIComponent(jsonString));
    if (defaultStageData.ro) {
      for (i in defaultStageData.ro) {
        var role = defaultStageData.ro[i];
        game.girls.loadAsync(role.name, role.skin, preview);
      }
      game.girls.loadAll(defaultStageData.ro);
    }
    gameview.selectBackground.val(defaultStageData.bg).change();
  }

};

var gameview = {
  role : [],
  bgImage : [],
  handler : null,
  init : function(){
    gameview.canvas = $('.gameCanvas');
    gameview.selectBackground = $(".gameSelectBackground > select");
    gameview.showFPS = $(".gameShowFPS > input");
    gameview.selectCharacter = $(".gameSelectCharacter > select");
    gameview.selectAnimation = $(".gameSelectAnimation > select");
    gameview.selectposX = $(".gameSelectposX > input");
    gameview.selectposY = $(".gameSelectposY > input");
    gameview.selectscale = $(".gameSelectscale > input");
    gameview.turnRole = $(".gameTurnRole");
    gameview.stopRole = $(".gameStopRole");
    gameview.saveStageBtn = $(".gameSaveStage");
    gameview.savePngBtn = $(".gameSavePng");
    gameview.removeRole = $(".gameRemoveRole");
    gameview.isUpdate = true;
    gameview.isShowFPS = true;

    var stringBackground = "<option>空</option>";
    for(var i = 0;i < game.background.length; i++)
      stringBackground += "<option>" + game.background[i] + "</option>";
    gameview.selectBackground.html(stringBackground);

    gameview.selectBackground.change(function(){
      gameview.changeBackground(this.selectedIndex);
    });

    gameview.showFPS.change(function(){
      gameview.isShowFPS = this.checked;
    });

    gameview.saveStageBtn.click(function(){
      gameview.saveStage();
    });

    gameview.savePngBtn.click(function(){
      gameview.savePng();
    });

    var stringCharacter = "<option>請選擇</option>";
    gameview.selectCharacter.html(stringCharacter);

    gameview.selectCharacter.change(function(){
      if(this.selectedIndex == 0) return ;
      var role = gameview.role[this.selectedIndex - 1];
      gameview.selectposX.val(role.x);
      gameview.selectposY.val(role.y);
      gameview.selectscale.val(Math.abs(role.scale.x) * 1000);
      gameview.focusRole = role;
      var stringAnimations = "";
      for(var i = 0;i < role.spineData.animations.length;i++){
        var defaultAnimation = "";
        if(role.animation==role.spineData.animations[i].name){
          defaultAnimation = " selected";
        }
        stringAnimations += "<option" + defaultAnimation + ">" + role.spineData.animations[i].name + "</option>";
      }
      gameview.selectAnimation.html(stringAnimations);
    });

    gameview.selectAnimation.change(function(){
      gameview.changeAnimation(this.selectedIndex);
    });

    gameview.removeRole.click(function(){
      var n =gameview.selectCharacter[0].selectedIndex;
      if(n == 0) return ;
      gameview.stage.removeChild(gameview.role[n - 1]);
      gameview.selectCharacter[0].remove(n);
      gameview.role.splice(n - 1, n);
      n =gameview.selectCharacter[0].selectedIndex;
      gameview.focusRole = null;
      gameview.selectAnimation.html("");
    });

    gameview.turnRole.click(function(){
      gameview.focusRole.scale.x *= -1;
    });

    gameview.stopRole.click(function(){
      if(gameview.isUpdate){
        gameview.isUpdate = false;
        gameview.stopRole.html("開始");
      }else{
        gameview.isUpdate = true;
        gameview.stopRole.html("停止");
      }
    });

    gameview.selectX = 1920 / 2;
    gameview.selectY = 1080 / 2;
    gameview.selectScale = 1;

    gameview.selectposX.attr("max", 1920);
    gameview.selectposY.attr("max", 1080);
    gameview.selectposX.val(gameview.selectX);
    gameview.selectposY.val(gameview.selectY);
    gameview.selectscale.val(gameview.selectScale * 1000);

    gameview.stage = new PIXI.Container;
    gameview.renderer = PIXI.autoDetectRenderer(1920, 1080, { transparent : true });
    gameview.background = new PIXI.Sprite(PIXI.Texture.EMPTY);
    gameview.stage.addChild(gameview.background);
    gameview.lastTime = new Date().getTime();
    gameview.nowTime = new Date().getTime();
    gameview.fpsText = new PIXI.Text("0", { fill : "#ffffff"});
    gameview.fpsText.x = 1;
    gameview.fpsText.y = 0;
    gameview.stage.addChild(gameview.fpsText);
    gameview.animationFrame = window.requestAnimationFrame(gameview.animate);
    gameview.canvas.html(gameview.renderer.view);
  },
  animate : function(){
    gameview.lastTime = gameview.nowTime;
    gameview.nowTime = new Date().getTime();
    gameview.animationFrame = window.requestAnimationFrame(gameview.animate);
    if(gameview.isShowFPS)
      gameview.fpsText.text = Math.floor(1000 / (gameview.nowTime - gameview.lastTime));
    else
      gameview.fpsText.text = "";
    if(gameview.isUpdate)
      for(var i = 0; i < gameview.role.length; i++)
        gameview.role[i].update( (gameview.nowTime - gameview.lastTime) / 1000);
    if(gameview.focusRole){
      gameview.focusRole.x = gameview.selectposX.val();
      gameview.focusRole.y = gameview.selectposY.val();
      if(gameview.focusRole.scale.x > 0)
        gameview.focusRole.scale.x = gameview.selectscale.val() / 1000;
      else
        gameview.focusRole.scale.x = -gameview.selectscale.val() / 1000;
      gameview.focusRole.scale.y = gameview.selectscale.val() / 1000;
    }
    gameview.renderer.render(gameview.stage);
  },

  changeAnimation : function(num){
    var name = gameview.focusRole.spineData.animations[num].name;
    var isload = true;
    if(name == "die" || name == "reload" || name == "victory")
      isload = false;
    gameview.focusRole.state.setAnimationByName(0, name, isload, 0);
    gameview.focusRole.update(0);
  },

  addRole : function(skeletonData, selectedAnimation){
    var role = gameview.role[gameview.role.length] = new PIXI.spine.Spine(skeletonData);
    var name = skeletonData.name;
    gameview.selectposX.val(skeletonData.x || gameview.selectX);
    gameview.selectposY.val(skeletonData.y || gameview.selectY);
    var scale = skeletonData.scale || gameview.selectScale;
    var isMirror = false;
    if (scale < 0) {
      scale = scale*-1;
      isMirror = true;
    }
    gameview.selectscale.val(scale * 1000);
    gameview.focusRole = role;
    var stringAnimations = "";
    var defaultAnimationId = 0;
    for(var i = 0;i < role.spineData.animations.length;i++){
      var defaultAnimation = "";
      if(selectedAnimation==role.spineData.animations[i].name){
        defaultAnimation = " selected";
        defaultAnimationId = i;
      }
      stringAnimations += "<option" + defaultAnimation + ">" + role.spineData.animations[i].name + "</option>";
    }
    gameview.selectAnimation.html(stringAnimations);
    gameview.changeAnimation(defaultAnimationId);
        role.x = skeletonData.x || gameview.selectX;
        role.y = skeletonData.y || gameview.selectY;
        role.scale.x = (isMirror) ? scale*-1 : scale || gameview.selectScale;
        role.scale.y = scale || gameview.selectScale;
        role.animation = skeletonData.animation || selectedAnimation;
        role.skeleton.setToSetupPose();
        role.update(0);
        role.autoUpdate = false;
    var codeName = (girlsDataTw[skeletonData.code]) ? girlsDataTw[skeletonData.code].name : name;
    var stringCharacter = "<option>" + codeName + " " + name + "</option>";
    gameview.selectCharacter.append(stringCharacter);
    gameview.selectCharacter[0].selectedIndex = gameview.role.length;
    gameview.stage.addChild(role);
  },
  changeBackground : function(n){
    if (n == 0 && gameview.background) {
      gameview.background.texture = PIXI.Texture.EMPTY;
      gameview.background.filename = '空';
      return;
    }
    if (gameview.bgImage[n-1]) {
      gameview.background.texture = gameview.bgImage[n-1];
      gameview.background.filename = game.background[n-1];
      gameview.background.scale.x = gameview.renderer.width / gameview.bgImage[n-1].width;
      gameview.background.scale.y = gameview.renderer.height / gameview.bgImage[n-1].height;
    } else {
      var name = "bg" + game.background[n-1];
      var path = resPasePath + "background/" + game.background[n-1] + ".jpg"
      PIXI.loader.add(name, path).load(function(loader, resources){
        gameview.bgImage[n - 1] = resources[name].texture;
        gameview.background.filename = game.background[n-1];
        gameview.background.texture = gameview.bgImage[n - 1];
        gameview.background.scale.x = gameview.renderer.width / gameview.bgImage[n-1].width;
        gameview.background.scale.y = gameview.renderer.height / gameview.bgImage[n-1].height;
      });
    }
  },
  saveStage : function()
  {
    this.handler.saveStage(gameview);
  },
  savePng : function()
  {
    this.handler.savePng(gameview);
  }
}
