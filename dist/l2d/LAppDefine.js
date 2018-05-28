var LAppDefine = {
    
    // デバッグ。trueのときにログを表示する。
    DEBUG_LOG : false,
    DEBUG_MOUSE_LOG : false, // マウス関連の冗長なログ
    //DEBUG_DRAW_HIT_AREA : true, // 当たり判定の可視化
    //DEBUG_DRAW_ALPHA_MODEL : true, // 半透明のモデル描画を行うかどうか。
    
    //  全体の設定
    
    // 画面
    VIEW_MAX_SCALE : 2,
    VIEW_MIN_SCALE : 0.8,

    VIEW_LOGICAL_LEFT : -1,
    VIEW_LOGICAL_RIGHT : 1,

    VIEW_LOGICAL_MAX_LEFT : -2,
    VIEW_LOGICAL_MAX_RIGHT : 2,
    VIEW_LOGICAL_MAX_BOTTOM : -2,
    VIEW_LOGICAL_MAX_TOP : 2,
    
    // モーションの優先度定数
    PRIORITY_NONE : 0,
    PRIORITY_IDLE : 1,
    PRIORITY_NORMAL : 2,
    PRIORITY_FORCE : 3,
    
    // モデルの後ろにある背景の画像ファイル
    //BACK_IMAGE_NAME : "assets/image/back_class_normal.png",
    BACK_IMAGE_NAME : "",

    // 外部定義ファイル(json)と合わせる
    MOTION_GROUP_IDLE : "idle", // アイドリング
    MOTION_GROUP_TAP_BODY : "", // 体をタップしたとき
    MOTION_GROUP_FLICK_HEAD : "flick_head", // 頭を撫でた時
    MOTION_GROUP_PINCH_IN : "pinch_in", // 拡大した時
    MOTION_GROUP_PINCH_OUT : "pinch_out", // 縮小した時
    MOTION_GROUP_SHAKE : "shake", // シェイク

    // 外部定義ファイル(json)と合わせる
    HIT_AREA_HEAD : "head",
    HIT_AREA_BODY : "body"
    
};
