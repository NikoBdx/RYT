@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto">

            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                Cette section contient les principales informations sur RYT. Si vous ne trouvez pas de réponse à votre question, contactez-nous !
            </div>
        
                <div class="faqHeader accordion" id="qg">Questions générales</div>
                <div class="card">
                    <div class="card-header p-2" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            L'enregistrement du compte est-il requis ?
                            </button>
                            </h5>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#qg">
                        <div class="card-body">
                        L'enregistrement d'un compte sur <strong>RYT</strong> n'est requis que si vous louez un outil ou que vous le proposez à la location. Cela garantit un canal de communication valide pour toutes les parties impliquées dans les transactions.
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-2" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Je n'arrive pas à m'inscrire
                            </button>
                            </h5>
                    </div>

                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#qg">
                        <div class="card-body">
                        L’inscription est rapide. Vous devez entrer un email valide et un mot de passe complexe. Si vous ne pouvez toujours pas vous inscrire, contactez-nous.. 
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header p-2" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            Quelle est la devise utilisée pour toutes les transactions ?
                            </button>
                            </h5>
                    </div>

                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#qg">
                        <div class="card-body">
                        Tous les prix sont en euros. <strong>RYT</strong> propose ses services uniquement en France. 
                        </div>
                    </div>
                </div>
            

            
                <div class="faqHeader accordion" id="lou">Loueurs</div>

                <div class="card">
                    <div class="card-header p-2" id="headingFour">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                            Que puis-je louer sur RYT?
                            </button>
                            </h5>
                    </div>

                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#lou">
                        <div class="card-body">
                        Sur RYT, vous pouvez louer des outils de Bricolage (perceuse, meuleuse, coffret tournevis, bétonnière, échelle) etc…, Jardinage (débroussailleuse, tondeuse, taille haie, brouette) etc…
        Auto (extracteur, clés spécifiques, cric ) etc… C’est tout!
                        </div>
                    </div>
                </div>
            

            
                <div class="faqHeader accordion" id="loc">Locataires</div>

                <div class="card">
                    <div class="card-header p-2" id="headingFive">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                            Ai-je vraiment le droit de louer?
                            </button>
                            </h5>
                    </div>

                    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#loc">
                        <div class="card-body">
                        OUI, un particulier est en droit de louer son propre matériel. En revanche, il faut être prudent et respecter quelques consignes simples pour que tout se passe au mieux. Lisez nos conseils et votre transaction se déroulera pour le mieux!
                        </div>
                    </div>
                </div>
               
        </div>
    </div>
@endsection
