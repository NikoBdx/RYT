<html>
    <head>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 25px;

            }
            header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                background-color: #EEAC18;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                background-color: #EEAC18;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            width: 100%;
            border-spacing: 0px 15px ;
            }

            #customers td, #customers th {
            padding: 8px;
            }

            #customers .kern{
            background-color: #18EEAC;
               border-bottom: #18EEAC 3px solid;
            }
            #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #18EEAC;
            color: white;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>

        <header>
            BON DE COMMANDE RYT - Rent Your Tool
        </header>

        <footer>
            Copyright &copy; <?php echo date("Y");?> 
        </footer>
    
    <div class="container border-dark">

            <table id="customers" class="table table-responsive ">
                <thead>
                  <tr>
                    <th scope="col">{{'Date : ' . date(' Y-m-d ')}}</th>
                    
                    <th scope="col">  </th>
                    <th scope="col"> {{ 'N° de Commande : '. $payment->order->id }}  </th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
                <tr class="kern">
                    <!-- Données Utilisateur demandant une location ------------------------------------------->
                    <td> Client : </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>{{ $payment->user->firstname.' '. $payment->user->lastname}}</td>
                </tr> 
                <tr> 
                    <td>{{ $payment->user->address}}</td>
                </tr>
                <tr> 
                    <td>{{$payment->user->town .' '.$payment->user->cp}}</td>
                </tr> 
                <tr class="kern"> 
                    <!-- Données l'objet a louer -------------------------------------------------------------->
                    <td>Objet emprunter : </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td> Titre :  {{ $payment->tool->title}}</td>
                </tr>
                <tr>
                    <td>Description : {{ $payment->tool->description}}</td>
                    <td></td>
                </tr>
                <tr class="kern"> 
                    <!-- Données relatives au prix ------------------------------------------------------------>
                    <td scope="col"> Prix de location par jour</td>
                    <td scope="col"> Nbr. de jour</td>
                    <td scope="col"> Prix total</td>
                </tr>
                <tr> 
                    <td>{{ $payment->tool->price}} €</td>
                    <td>{{ $payment->price / $payment->tool->price }}</td>
                    <td>{{ $payment->price}} €</td>
                </tr>
                <tr class="kern">
                    <!-- Données supplementaires sur la commande --------------------------------------------->
                    <td> Date de la commande </td>
                    <td> Debut </td>
                    <td> Fin </td>
                </tr>
                <tr>
                    <td></td>
                    <td>{{ $payment->order->start_date }}</td>
                    <td>{{ $payment->order->end_date }} </td>
                    <td></td>
                </tr>
                </tbody>
              </table>
    
        </div>
    </body>

