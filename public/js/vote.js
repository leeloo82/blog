
/*recupération du selecteur vote
* querySelectorAll retourne les elements du selecteur demander
* */
btnVote = document.querySelectorAll('.vote');

/*
*
* */
btnVote.forEach( (element) => {
    //ecoute d'un evenement click
    element.addEventListener('click' , (e) => {
        console.log(e.target.dataset.vote)
        action = e.target.dataset.vote;

        //appel de la fonction de traitement de l'action d'écoute
        Vote(action);

    })
})
/*
* INPUT:
* PROCESS:
* OUTPUT:
* NOTE:*/
function Vote(action) {
    /*fectch prends la route vers laquel ce diriger pour acceder a la fonction*/
    fetch('/article/vote/'+ action).then(function(response) {
        if(response.ok) {
            response.json().then(function (response) {
                nbVotes = response.vote;
                console.log(nbVotes);
                document.getElementById('nbVotes').innerText = nbVotes;
            });

        } else {
            console.log('Mauvaise réponse du réseau');
        }
    })

}