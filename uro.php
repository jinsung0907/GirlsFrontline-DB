
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<meta name=viewport content="width=873px">
<title> Ouroboros Finder </title>
<style type="text/css" >

body {
  font-size: 16px;
}

.small {
  font-size: 12px; /* 75% of the baseline */
}

.large { 
  font-size: 20px; /* 125% of the baseline */
}
</style>
</head>
<body>
<div id="container">
	<div id = "mainimage" style = " display: inline-block; position: absolute; left: 10px; right: 10px; top: 30px" >
	<img src = "img/uro/map.png" alt = "Uroboros-Chan-Map" id = "map" style = "position: absolute; left: 0px; top: 0px;">
	</div>
	<div id = "pholder" style = "height: 480px;">
	&nbsp;
	</div>
	<div>
	<p style="font-size: 20px"> <a href="#" onclick="javascript:reset()">Reset</a><!--<button onclick = "javascript:disp(true)" >Find Ouroboros</button> <button onclick = "javascript:reset()">Reset</button>--></p>
	<h2>Ouroboros Finder<small> v0.0.4 </small></h2>
	<p>사용법: 첫 턴에, 헬리포트에서 제1 소대를 한 칸 내린 후, 제2 소대를 헬리포트에 소환합니다.</p>
	<p>턴 종료 후 바로 다음 턴인 2턴째에, 맵 아래쪽의 점령 상태를 마우스 클릭으로 기록합니다.</p>
	<p>보라색으로 표시된 곳이 우로보로스가 있을 수 있는 위치입니다.</p>
	<p><a href="qna.html">QnA, Disclaimer, Patch Note, Implementation Detail</a></p>
	<p><a href="bingo.html">14빙고 확률 계산기</a></p>
	</div>
</div>



<div id = "cache">
<img src = "img/uro/ocu1.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu3.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu5.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu6.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu8.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu9.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu10.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu11.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu13.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu14.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu15.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu16.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu17.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu19.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu20.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu21.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu22.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu24.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu25.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu26.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ocu27.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans1.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans3.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans5.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans6.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans8.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans9.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans10.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans11.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans13.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans14.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans15.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans16.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans17.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans19.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans20.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans21.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans22.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans24.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans25.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans26.png" alt = "cache" width=1 height = 1 hidden = hidden>
<img src = "img/uro/ans27.png" alt = "cache" width=1 height = 1 hidden = hidden>
</div>

<script>

var vno = 28
var edata = [[1,2],[1,3],[2,3],[3,4],[4,5],[4,10],[5,6],[6,7],[6,8],[7,8],[8,9],[8,17],[9,10],[9,15],[10,11],[11,12],[12,13],[12,14],[14,16],[15,16],[16,18],[16,19],[17,18],[18,19],[19,20],[20,21],[20,28],[21,22],[22,23],[23,24],[23,25],[25,26],[26,27],[27,28]]

//var vdata = [[0,0],[4,10],[105,63],[7,108],[59,202],[44,293],[63,383],[158,428],[199,352],[181,256],[165,156],[239,78],[375,130],[384,32],[392,213],[278,275],[387,308],[264,413],[375,418],[505,401],[626,398],[653,288],[693,179],[775,95],[796,10],[776,193],[796,272],[816,410],[736,345]]

var vdata = [[0,0],[1,7],[0,0],[5,103],[0,0],[42,290],[59,379],[0,0],[195,350],[177,250],[162,154],[236,75],[0,0],[381,27],[388,210],[272,267],[383,305,],[263,411],[0,0],[501,397],[625,395],[651,287],[690,175],[0,0],[793,7],[772,189],[792,271],[815,407],[0,0]]

var adjlist = []

var uroboros = [2, 4, 7, 18, 28, 23]
var firstturnmob = [10, 17, 26]
var firstturngen = [4, 12, 28]
var poslist = []

var radarlist = [3, 6, 15, 22]
var boxlist = [8, 13, 25]
var heliportlist = [2, 4, 7, 12, 18, 28, 23]
var ds = false

function init()
{
    poslist[0] = 0
    for(var i=1; i<=vno; ++i)
    {
        adjlist[i] = []
        poslist[i] = 0;
    }
    for(var i=1; i<=heliportlist.length; ++i)
        poslist[heliportlist[i]] = -1
    for(var i=0; i<edata.length; ++i)
    {
        var x = edata[i]
        adjlist[x[0]].push(x[1])
        adjlist[x[1]].push(x[0])
    }
} init();

function reset()
{
    for(var i=1; i<=vno; ++i)poslist[i] = 0;
    for(var i=0; i<heliportlist.length; ++i)
        poslist[heliportlist[i]] = -1
    for(var i=1; i<=vno; ++i) if(poslist[i] == 0)toggle(i), toggle(i)
}
function track(mobarr, ansarr)
{
    var prod = 1
    for(var i = 0; i < mobarr.length; ++i) prod *= mobarr[i].length
    for(var bt = 0; bt < prod; ++bt)
    {
        var tmp = bt
        var pos = poslist.slice()
        var flag = true
        var pdata = mobarr[0][tmp%mobarr[0].length]
        for(var i = 0; i < mobarr.length; ++i)
        {
            var p = mobarr[i][tmp % mobarr[i].length]
            tmp = tmp/mobarr[i].length
            tmp = tmp | 0
            if(pos[p] == 0 || pos[p] == -2)
            {
                flag = false
                break
            }
            pos[p] = -2
            
        }
        if(!flag) continue
        for(var i=1; i<=vno; ++i)
            if(pos[i] == 1) 
            {
                flag = false
                break
            }
        if(!flag) continue 
        ansarr.push(pdata)
    }
}

function find()
{
    var ans = []
    for(var i = 0; i < uroboros.length; ++i)
    {
        mobarr = [] 
        mobarr.push(adjlist[uroboros[i]])
        for(var j=0; j<firstturnmob.length; ++j)
            mobarr.push(adjlist[firstturnmob[j]])
        for(var j=0; j<firstturngen.length; ++j)
            if(firstturngen[j] != uroboros[i])
                mobarr.push(adjlist[firstturngen[j]])
        track(mobarr, ans)
    }
    //exceptional case
    track([[25],[26],[27], adjlist[10], adjlist[17], adjlist[4], adjlist[12]], ans)
    
    return ans
}

function disp(p)
{
    x = find()
    if(x.length==0 && p)
    {
        alert("입력이 잘못되었거나, 예상치 못한 경우입니다.");
        return;
    }
    for(var i=0; i<x.length; ++i)
        document.getElementById("node"+x[i]).setAttribute("src", "img/uro/ans"+x[i]+".png")
    ds = true
}

function rtoggle(x)
{
	toggle(x)
	disp(false)
}



function toggle(x)
{
    if(ds)
    {
        ds = false;
        for(var i=1; i<=vno; ++i) if(poslist[i] == 1) toggle(i), toggle(i)
    }
    if(poslist[x] == -1)
        return;
    poslist[x] = 1 - poslist[x]
    var v = poslist[x]
    
    if(v==0)
        document.getElementById("node"+x).setAttribute("src", "img/uro/enemy_blank_ocu.png");
    else
    {
        var img = "img/uro/ocu"+x+".png"
        document.getElementById("node"+x).setAttribute("src", img)
    }
}


var m = document.getElementById("mainimage")
for(var i = 1; i <= vno; ++i)
{
    if(vdata[i][0] == 0) continue;
    var im = document.createElement("img")
    im.setAttribute("src", "img/uro/enemy_blank_ocu.png")
    im.style.position = "absolute"
    im.setAttribute("id", "node"+i)
    im.style.left = vdata[i][0]+"px"
    im.style.top = vdata[i][1]+"px"
    im.setAttribute("onclick",  "javascript:rtoggle("+i+");")
    m.appendChild(im)
}
</script>
</body>
</html>