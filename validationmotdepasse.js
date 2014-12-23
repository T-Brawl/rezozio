function mememdp()
{
    var password = document.getElementById('mdp');
    var password2 = document.getElementById('mdp2');
    if(password.value == password2.value){
      password2.setCustomValidity("");
      
    }else{
      password2.setCustomValidity("Les mots de passe ne correspondent pas");
    }
}

