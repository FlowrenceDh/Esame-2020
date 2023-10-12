<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sito Web - Protezione civile</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link 
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" 
  rel="stylesheet"> -->

  <!-- Custom styles for this template-->
  <link href="css/style.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="HomeProtezioneCivile.php">        
        <div class="sidebar-brand-text mx-3">Protezione Civile</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="HomeProtezioneCivile.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Homepage</span>
	    </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" 
        aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Dati Paziente</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Manipolazione dati:</h6>
            <a class="collapse-item" href="ElencoPazienti.php">Elenco Pazienti</a>
            <a class="collapse-item" href="Inserisci.php">Nuovo Paziente</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>          

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">			
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" 
              aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Riccardo Simeoni</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <?php
          if(isset($_GET['mod']))
          {
            if($_GET['mod'] == "upd")
              echo "<h1 class=\"h3 mb-2 text-gray-800\">Modifica Dati Pazienti</h1>
                    <p class=\"mb-4\">In questa schermata si può modificare il contatto selezionato</p>";
            else
              echo "<h1 class=\"h3 mb-2 text-gray-800\">Info Dati Pazienti</h1>
                    <p class=\"mb-4\">Ecco i dettagli del contatto scelto</p>";
          }
          else echo "<h1 class=\"h3 mb-2 text-gray-800\">Modifica Dati Pazienti</h1>
          <p class=\"mb-4\">In questa schermata si può modificare il contatto selezionato</p>";
          ?>
          <!-- DataTale Modifica Pazienti -->
          <?php
            $host="localhost";
            $user="root";
            $password="";
            $dbname="covid-19";
            // stringa di connessione al DBMS
            $connessione = new mysqli($host, $user, $password, $dbname);
            // verifica su eventuali errori di connessione
            if ($connessione->connect_errno) {
                echo "Connessione fallita: ". $connessione->connect_error . ".";
                exit();
            }
            echo "<br>";
          ?>



          <div class="card shadow mb-4">
            <div class="card-header py-3">
            <?php
              if(isset($_GET['mod']))
              {
                if($_GET['mod'] == "upd")
                echo "<h6 class=\"m-0 font-weight-bold text-primary\">Modifica Paziente</h6>";
                else
                echo "<h6 class=\"m-0 font-weight-bold text-primary\">Dettagli Paziente</h6>";
              }
              else echo "<h6 class=\"m-0 font-weight-bold text-primary\">Modifica Paziente</h6>";
            ?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <?php
                        if(isset($_GET['id']))
                        {
                            
                            //query
                            $CF=$_GET['id'];
                            $sql="select paziente.* from paziente where paziente.CF=\"".$CF."\"";
                            $result=$connessione->query($sql);
                            if(!$result)
                            {
                              echo "Errore nella esecuzione della query <br>";
                            }

                            //iterazione per la verifica della presenza del record da modificare nel database
                            if(!$result)
                            {
                              echo "Errore nella query <br>";
                            }
                            else
                            {
                              $row=$result->fetch_assoc();
                              if($_GET['mod']=="upd")
                              {
                                echo "<form method=\"POST\" action=\"Modifica.php\">
                                  <tr>
                                    <th>Codice Fiscale</th>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Indirizzo</th>
                                  </tr>
                                  <tr>
                                    <td>
                                      <label for=\"CF\">".$row['CF']."</label>
                                      <input type=\"hidden\" id=\"CF\" name=\"CF\" value=\"".$row['CF']."\">
                                    </td>

                                    <td><input type=\"text\" name=\"nom\" class=\"form-control\" 
                                    value=\"".$row['nome']."\"></td>

                                    <td><input type=\"text\" name=\"cog\" class=\"form-control\" 
                                    value=\"".$row['cognome']."\"></td>

                                    <td><input type=\"text\" name=\"Addr\" class=\"form-control\" 
                                    value=\"".$row['indirizzo']."\"></td>
                                  </tr>  
                                  <tr>
                                    <th>Città</th>
                                    <th>Provincia</th>
                                    <th>Regione</th>
                                    <th>Stato</th>
                                  </tr>
                                  <tr>

                                    <td><input type=\"text\" name=\"City\" class=\"form-control\" 
                                    value=\"".$row['citta']."\"></td>

                                    <td><input type=\"text\" name=\"Provincia\" class=\"form-control\" 
                                    value=\"".$row['provincia']."\"></td>

                                    <td><input type=\"text\" name=\"Region\" class=\"form-control\" 
                                    value=\"".$row['regione']."\"></td>

                                    <td>";     
                                        
                                if($row['stato'] == "Infetto")       
                                echo  "<select class='custom-select' name=\"StatoS\">
                                          <option selected>Infetto</option>
                                          <option>Deceduto</option>
                                          <option>Guarito</option>
                                        </select>";
                                if($row['stato'] == "Deceduto")       
                                echo  "<select class='custom-select' name=\"StatoS\">
                                          <option>Infetto</option>
                                          <option selected>Deceduto</option>
                                          <option>Guarito</option>
                                        </select>";
                                if($row['stato'] == "Guarito")       
                                echo  "<select class='custom-select' name=\"StatoS\">
                                          <option>Infetto</option>
                                          <option>Deceduto</option>
                                          <option selected>Guarito</option>
                                        </select>";    
                          
                                echo  " </td></tr></table><br>
                                        <button class='btn' onclick='window.history.back()' type='button'>
                                        Indietro</button>
                                        <button class='btn btn-outline-primary' type='submit' name='check'>
                                        Salva</button>
                                      </form>";  
                            }
                            else
                            {
                              echo "
                                    <tr>
                                      <th>Codice Fiscale</th>
                                      <th>Nome</th>
                                      <th>Cognome</th>
                                      <th>Indirizzo</th>
                                    </tr>
                                    <tr>
                                      <td>".$row['CF']."</td> 
                                      <td>".$row['nome']."</td>
                                      <td>".$row['cognome']."</td>
                                      <td>".$row['indirizzo']."</td>
                                    </tr>
                                    <tr>
                                      <th>Città</th>
                                      <th>Provincia</th>
                                      <th>Regione</th>
                                      <th>Stato di Salute</th>
                                    </tr>
                                    <tr>
                                      <td>".$row['citta']."</td>
                                      <td>".$row['provincia']."</td>
                                      <td>".$row['regione']."</td>
                                      <td>".$row['stato']."</td>
                                    </tr>
                                    </table>
                                    <button class='btn' onclick='window.history.back()' type='button'>
                                    Indietro</button>";
                            }
                          }
                        }

                            if(isset($_POST['check']))
                            {
                              $CF=$_POST['CF'];
                              $Nome=$_POST['nom'];
                              $Cognome=$_POST['cog'];
                              $indirizzo=$_POST['Addr'];
                              $City=$_POST['City'];
                              $Provincia=$_POST['Provincia'];
                              $Region=$_POST['Region'];
                              $Stato=$_POST['StatoS'];

                              //query modifica valori 
                              $sql="update paziente set 
                              paziente.nome=\"".$Nome."\", 
                              paziente.cognome=\"".$Cognome."\", 
                              paziente.indirizzo=\"".$indirizzo."\",
                              paziente.citta=\"".$City."\", 
                              paziente.provincia=\"".$Provincia."\",
                              paziente.regione=\"".$Region."\", 
                              paziente.stato=\"".$Stato."\"
                              where paziente.CF=\"".$CF."\"";
                              $result=$connessione->query($sql);
                              if(!$result)
                              {
                                  echo "Errore nella esecuzione della query <br>";
                              }
                              else 
                              {
                                  echo "<h4>Informazioni aggiunte con successo</h4>";
                                  echo "<button onclick=\"location.href='ElencoPazienti.php'\" 
                                        class='btn btn-outline-primary' onclick='location.' type='button'>
                                        Torna all'elenco</button>";
                              }
                            }
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy;</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>
</body>

</html>