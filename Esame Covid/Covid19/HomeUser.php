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
  <!--<link 
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" 
  rel="stylesheet">-->

  <!-- Custom styles for this template-->
  <link href="css/style.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="HomeUser.php">        
        <div class="sidebar-brand-text mx-3">Riccardo Simeoni webpage</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="HomeUser.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Homepage</span>
	      </a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="http://www.protezionecivile.gov.it/">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Chi siamo</span>
	      </a>
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
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">&nbsp;</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
	
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Homepage</h1>
            <form method="GET" action="HomeUser.php">            
              <div class="input-group-append">            
                <select class="custom-select" name="regione">
                  <option value="all" selected>Seleziona la regione...</option>
                  <option>Abruzzo</option>
                  <option>Basilicata</option>
                  <option>Calabria</option>
                  <option>Campania</option>
                  <option>Emilia-Romagna</option>
                  <option>Friuli Venezia Giulia</option>
                  <option>Lazio</option>
                  <option>Liguria</option>
                  <option>Lombardia</option>
                  <option>Marche</option>
                  <option>Molise</option>
                  <option>Piemonte</option>
                  <option>Puglia</option>
                  <option>Sardegna</option>
                  <option>Sicilia</option>
                  <option>Toscana</option>
                  <option>Trentino-Alto Adige</option>
                  <option>Umbria</option>
                  <option>Valle D'Aosta</option>
                  <option>Veneto</option>
                </select>                
                <button class="btn btn-outline-secondary" type="submit">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </form>
          </div>

          <!-- Content Row -->
          <div class="row">
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
				else echo "<br><br>";
        
        //controllo di valori nel campo regione dell'array globale GET tramite la funzione isset()
        if(isset($_GET['regione']))
        {
          //valore della form
          $regione=$_GET['regione'];
        }
        else{
          //valore di default
          $regione="all";
        }
        
				//Dati Covid
				if($regione=="all")
				{
				  $sql="SELECT COUNT(*) as tot, stato FROM paziente GROUP BY stato ORDER BY stato"; 
				}
				else
				{
				  $sql="SELECT COUNT(*) as tot, stato FROM paziente WHERE regione='".$regione."' GROUP BY stato 
          ORDER BY stato";
				}

				$result=$connessione->query($sql);

				if(!$result)
				{
				  echo "<p class='h3 mb-0 text-gray-800'>Errore nella esecuzione della query</p>";
				}
				else 
				{
          $deceduto=0;
          $guarito=0;
          $infetto=0;
				  while($row=$result->fetch_assoc()) {
            if($row['stato'] == "Deceduto") 
            {
              $deceduto=$row['tot'];
            }
            if($row['stato'] == "Guarito") 
            {
              $guarito=$row['tot'];
            }
            if($row['stato'] == "Infetto")
            {
              $infetto=$row['tot'];
            }
				  }
          $totale = $deceduto + $guarito + $infetto;
        ?>
				  
				<!-- Totale Pazienti Visitati -->
				<div class="col-xl-3 col-md-6 mb-4">
				  <div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
					  <div class="row no-gutters align-items-center">
						<div class="col mr-2">
						  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Totale Pazienti e Vittime</div>
						  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totale; ?></div>
						</div>
						<div class="col-auto">
						  <i class="fas fa-calendar fa-2x text-gray-300"></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>

				<!-- Totale Positivi -->
				<div class="col-xl-3 col-md-6 mb-4">
				  <div class="card border-left-warning shadow h-100 py-2">
					<div class="card-body">
					  <div class="row no-gutters align-items-center">
						<div class="col mr-2">
						  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Totale Positivi</div>
						  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $infetto; ?></div>
						</div>
						<div class="col-auto">
						  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>

				<!-- Totale Guariti -->
				<div class="col-xl-3 col-md-6 mb-4">
				  <div class="card border-left-success shadow h-100 py-2">
					<div class="card-body">
					  <div class="row no-gutters align-items-center">
						<div class="col mr-2">
						  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Totale Guariti</div>
						  <div class="row no-gutters align-items-center">
							<div class="col-auto">
							  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $guarito; ?></div>
							</div>
						  </div>
						</div>
						<div class="col-auto">
						  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>

				<!-- Totale Deceduti -->
				<div class="col-xl-3 col-md-6 mb-4">
				  <div class="card border-left-danger shadow h-100 py-2">
					<div class="card-body">
					  <div class="row no-gutters align-items-center">
						<div class="col mr-2">
						  <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Totale Deceduti</div>
						  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $deceduto; ?></div>
						</div>
						<div class="col-auto">
						  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
						</div>
					  </div>
					</div>
				  </div>
				</div>			  
      
      <?php	  
      }          			
			  $connessione->close();
			?>
          
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Grafico Contagi</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" height="250px" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="vertical-align: top;">Grafico Andamento contagi...</th>                      
                    </tr>
                  </thead>
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
</body>

</html>