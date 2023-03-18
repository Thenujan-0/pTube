import './bootstrap';


function $(data){
    return document.querySelectorAll(data);
}

$(".videoCard").forEach(function(elem){
    elem.addEventListener("click",function(){
        console.log("clicked")
        let videoId=this.getAttribute("data-video")
        console.log(videoId)
        window.location.href="/video?link="+videoId
    })
})
const urlParams = new URLSearchParams(window.location.search);
const mode = urlParams.get('mode');
console.log(mode)
$("#btnNsfw")[0].textContent = mode=="NSFW"?"SFW": "NSFW";


$("#btnNsfw")[0].addEventListener("click",function(e){
    let text = e.target.textContent
    if (text=="NSFW"){
        window.location.href="/?mode=NSFW"
    }else{
        window.location.href="/?mode=SFW"
    }

})