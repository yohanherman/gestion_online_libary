
let PasswordConfirm2 = document.querySelector("#PasswordConfirm2")
let Password2 = document.querySelector("#Password2");
let btn = document.querySelector(".change");

function valid(){
    // console.log(btn);
    
        PasswordConfirm2.addEventListener("input",()=>{
            if(Password2.value !== PasswordConfirm2.value){
                btn.disabled=true;
                // return false;
              
            }else{
                btn.disabled=false;
        
                // return true;
            }
        })
    }
    valid();
    
    