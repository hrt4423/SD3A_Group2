/*並び替えセレクトボックス*/
var mamlistboxdiv;
        var mamlistboxa;
        var mamlistbox;
        var mamlistbox_active=false;
        window.addEventListener("load",function(){
          mamlistboxdiv=document.querySelector(".mamListBox>a>div");
          mamlistboxa=document.querySelector(".mamListBox>a");
          mamlistbox=document.querySelector(".mamListBox>select");
          mamlistboxa.addEventListener("click",function(event){
            if(mamlistbox_active==false){
              mamlistbox.style.display = "block";
              mamlistbox_active=true;
              mamlistbox.focus();
            }else{
              mamlistbox_active=false;
            }
          });
          mamlistbox.addEventListener("blur",function(){
            mamlistbox.style.display = "none";
          });
          mamlistbox.addEventListener("click",function(){
            mamlistboxdiv.innerHTML = mamlistbox.querySelectorAll('option')[mamlistbox.selectedIndex].innerHTML;
            mamlistbox_active=false;
            mamlistbox.blur();
          });
          document.documentElement.addEventListener("click",mamListboxOtherClick);
        });
        function mamListboxOtherClick(event){
          if(event.target==mamlistboxdiv){return;}
          if(event.target==mamlistboxa){return;}
          if(event.target==mamlistbox){return;}
          mamlistbox_active=false;
        }
/*並び替えセレクトボックス終了*/