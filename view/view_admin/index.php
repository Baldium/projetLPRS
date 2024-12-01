<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php';
include_once '../../repository/repositorySchumanConnect/EventRepository.php';
include_once '../../repository/repositoryAdmin/OffersRepository.php';
require_once '../../utils/flash.php';
display_flash_message();

$my_bdd = Bdd::my_bdd();
$adm = $my_bdd->prepare("SELECT `type` FROM `users` WHERE id_users = :id_user");
$adm->execute(array(
  "id_user" => $_SESSION['id_users']
));
$data_adm = $adm->fetch(PDO::FETCH_ASSOC);

if($data_adm['type'] != 1)
  header('Location: ../view_etudiants/notAccepted.html');


$users = UsersRespository::getAllUsersNotAccepted();
$offers = OffersRepository::getAllOffers();
$nbOffres = OffersRepository::getCountOffers();
$nbEvents = EventRepository::getCountEvents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_user'], $_POST['action'])) {
      $idUser = intval($_POST['id_user']);
      $action = ($_POST['action'] === 'accept') ? 1 : 0; // ternaire pris d'internet et j'ai readapter pour moi

      UsersRespository::rejectOrAcceptedCandidat($idUser, $action);

      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
  }
}
?>
<html lang="en">
 <head>
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <title>SchumanConnect - Dashboard Admin</title>
   <meta
     content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
     name="viewport"
  />
   <meta charset="utf-8"> 
   <link rel="icon" type="image/x-icon"/>


   <!-- Fonts and icons -->
   <script src="assets/js/plugin/webfont/webfont.min.js"></script>
   <script>
     WebFont.load({
       google: { families: ["Public Sans:300,400,500,600,700"] },
       custom: {
         families: [
           "Font Awesome 5 Solid",
           "Font Awesome 5 Regular",
           "Font Awesome 5 Brands",
           "simple-line-icons",
         ],
         urls: ["assets/css/fonts.min.css"],
       },
       active: function () {
         sessionStorage.fonts = true;
       },
     });
   </script>


   <!-- CSS Files -->
   <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
   <link rel="stylesheet" href="assets/css/plugins.min.css" />
   <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />


   <!-- CSS Just for demo purpose, don't include it in your project -->
   <link rel="stylesheet" href="assets/css/demo.css" />
 </head>
 <body>
   <div class="wrapper">
     <!-- Sidebar -->
     <div class="sidebar" data-background-color="dark">
       <div class="sidebar-logo">
         <!-- Logo Header -->
         <div class="logo-header" data-background-color="dark">
           <a href="index.php" class="logo">
             <img
               src="https://lyceerobertschuman.fr/wp-content/uploads/2021/11/Logo-New-RS.png"
               alt="navbar brand"
               class="navbar-brand"
               height="20"
            />
           </a>
           <div class="nav-toggle">
             <button class="btn btn-toggle toggle-sidebar">
               <i class="gg-menu-right"></i>
             </button>
             <button class="btn btn-toggle sidenav-toggler">
               <i class="gg-menu-left"></i>
             </button>
           </div>
           <button class="topbar-toggler more">
             <i class="gg-more-vertical-alt"></i>
           </button>
         </div>
         <!-- End Logo Header -->
       </div>
       <div class="sidebar-wrapper scrollbar scrollbar-inner">
         <div class="sidebar-content">
           <ul class="nav nav-secondary">
             <li class="nav-item active">
               <a
                 data-bs-toggle="collapse"
                 href="#dashboard"
                 class="collapsed"
                 aria-expanded="false"
               >
                 <i class="fas fa-home"></i>
                 <p>Bienvenue <?= $_SESSION['prenom']; ?></p>
               </a>
             </li>
             <li class="nav-section">
               <span class="sidebar-mini-icon">
                 <i class="fa fa-ellipsis-h"></i>
               </span>
               <h4 class="text-section">Actions</h4>
             </li>
             <li class="nav-item">
               <a data-bs-toggle="collapse" href="#base">
                 <i class="fas fa-users"></i>
                 <p>Utilisateurs</p>
                 <span class="caret"></span>
               </a>
               <div class="collapse" id="base">
                 <ul class="nav nav-collapse">
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                   <li>
                     <a href="#">
                       <span class="sub-item">//</span>
                     </a>
                   </li>
                 </ul>
               </div>
             </li>
             <li class="nav-item">
               <a data-bs-toggle="collapse" href="#sidebarLayouts">
                 <i class="fas fa-briefcase"></i>
                 <p>Offres</p>
                 <span class="caret"></span>
               </a>
               <div class="collapse" id="sidebarLayouts">
                 <ul class="nav nav-collapse">
                   <li>
                     <a href="./offers.php">
                       <span class="sub-item">Voir toutes les offres</span>
                     </a>
                   </li>
                   <li>
                     <a href="./offers.php">
                       <span class="sub-item">Modifier un offre</span>
                     </a>
                   </li>
                   <li>
                     <a href="./offers.php">
                       <span class="sub-item">Supprimer une offre</span>
                     </a>
                   </li>
                 </ul>
               </div>
             </li>
             <li class="nav-item">
               <a data-bs-toggle="collapse" href="#forms">
                 <i class="fas fa-calendar-alt"></i>
                 <p>Evénements</p>
                 <span class="caret"></span>
               </a>
               <div class="collapse" id="forms">
                 <ul class="nav nav-collapse">
                   <li>
                     <a href="evenements_admin.php">
                       <span class="sub-item">Voir tout les événements</span>
                     </a>
                   </li>
                   <li>
                     <a href="forms/forms.html">
                       <span class="sub-item">Modifier un événement</span>
                     </a>
                   </li>
                   <li>
                     <a href="forms/forms.html">
                       <span class="sub-item">Supprimer un événement</span>
                     </a>
                   </li>
                 </ul>
               </div>
             </li>
             <li class="nav-item">
               <a data-bs-toggle="collapse" href="#entreprise">
                 <i class="fas fa-building"></i>
                 <p>Entreprises</p>
                 <span class="caret"></span>
               </a>
               <div class="collapse" id="entreprise">
                 <ul class="nav nav-collapse">
                   <li>
                     <a href="./society_partner.php">
                       <span class="sub-item">Entreprises Partenaires</span>
                     </a>
                   </li>
                   <li>
                     <a href="./messagerie.php">
                       <span class="sub-item">Mes Messages</span>
                     </a>
                   </li>
                 </ul>
               </div>
             </li>
           </ul>
         </div>
       </div>
     </div>
     <!-- End Sidebar -->


     <div class="main-panel">
       <div class="main-header">
         <div class="main-header-logo">
           <!-- Logo Header -->
           <div class="logo-header" data-background-color="dark">
             <a href="index.php" class="logo">
               <img
                 src="../../public/assets/image/Logo_Schuman_Connect.png"
                 alt="navbar brand"
                 class="navbar-brand"
                 height="20"
              />
             </a>
             <div class="nav-toggle">
               <button class="btn btn-toggle toggle-sidebar">
                 <i class="gg-menu-right"></i>
               </button>
               <button class="btn btn-toggle sidenav-toggler">
                 <i class="gg-menu-left"></i>
               </button>
             </div>
             <button class="topbar-toggler more">
               <i class="gg-more-vertical-alt"></i>
             </button>
           </div>
           <!-- End Logo Header -->
         </div>
         <!-- Navbar Header -->
         <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
           <div class="container-fluid">
             <nav
               class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
             >
               <div class="input-group">
                 <div class="input-group-prepend">
                   <button type="submit" class="btn btn-search pe-1">
                     <i class="fa fa-search search-icon"></i>
                   </button>
                 </div>
                 <input
                   type="text"
                   placeholder="Faites votre recherche ... <?= $_SESSION['prenom']?> "
                   class="form-control"
                />
               </div>
             </nav>


             <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
               <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                 <a
                   class="nav-link dropdown-toggle"
                   data-bs-toggle="dropdown"
                   href="#"
                   role="button"
                   aria-expanded="false"
                   aria-haspopup="true"
                 >
                   <i class="fa fa-search"></i>
                 </a>
                 <ul class="dropdown-menu dropdown-search animated fadeIn">
                   <form class="navbar-left navbar-form nav-search">
                     <div class="input-group">
                       <input
                         type="text"
                         placeholder="Faire votre recherche ... le nom"
                         class="form-control"
                      />
                     </div>
                   </form>
                 </ul>
               </li>
               <li class="nav-item topbar-icon dropdown hidden-caret">
                 <ul
                   class="dropdown-menu messages-notif-box animated fadeIn"
                   aria-labelledby="messageDropdown"
                 >
                 </ul>
               </li>
               <li class="nav-item topbar-icon dropdown hidden-caret">
              
           
               </li>
               <li class="nav-item topbar-icon dropdown hidden-caret">
                 
               </li>


               <li class="nav-item topbar-user dropdown hidden-caret">
                 <a
                   class="dropdown-toggle profile-pic"
                   data-bs-toggle="dropdown"
                   href="#"
                   aria-expanded="false"
                 >
                   <div class="avatar-sm">
                     <img
                       src="data:image/png;base64,<?= base64_encode($_SESSION['profile_picture']); ?>" 
                       class="avatar-img rounded-circle"
                    />
                   </div>
                   <span class="profile-username">
                     <span class="fw-bold"><?= $_SESSION['nom']; echo " ";  echo $_SESSION['prenom']; ?></span>
                   </span>
                 </a>
                 <ul class="dropdown-menu dropdown-user animated fadeIn">
                   <div class="dropdown-user-scroll scrollbar-outer">
                     <li>
                       <div class="user-box">
                         <div class="avatar-lg">
                           <img
                             src="data:image/png;base64,<?= base64_encode($_SESSION['profile_picture']); ?>" 
                             alt="image profile"
                             class="avatar-img rounded"
                          />
                         </div>
                         <div class="u-text">
                           <h4><?= $_SESSION['prenom'] ?></h4>
                           <p class="text-muted"><?= $_SESSION['mail']; ?></p>
                           <a
                             href="profile.html"
                             class="btn btn-xs btn-secondary btn-sm"
                             >Gérer mon Profil</a
                           >
                         </div>
                       </div>
                     </li>
                     <li>
                       <div class="dropdown-divider"></div>
                       <a class="dropdown-item" href="../../utils/logout.php">Se déconnecter</a>
                     </li>
                   </div>
                 </ul>
               </li>
             </ul>
           </div>
         </nav>
         <!-- End Navbar -->
       </div>


       <div class="container">
         <div class="page-inner">
           <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
             <div>
               <h3 class="fw-bold mb-3">Panel Admin</h3>
             </div>
             <div class="ms-md-auto py-2 py-md-0">
               <a href="#" class="btn btn-primary btn-round">Ajouter un utilisateur</a>
             </div>
           </div>
           <div class="row">
             <div class="col-sm-6 col-md-3">
               <div class="card card-stats card-round">
                 <div class="card-body">
                   <div class="row align-items-center">
                     <div class="col-icon">
                       <div
                         class="icon-big text-center icon-primary bubble-shadow-small"
                       >
                         <i class="fas fa-users"></i>
                       </div>
                     </div>
                     <div class="col col-stats ms-3 ms-sm-0">
                       <div class="numbers">
                         <p class="card-category">Utilisateurs</p>
                         <h4 class="card-title">nb utilisateur</h4>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-sm-6 col-md-3">
               <div class="card card-stats card-round">
                 <div class="card-body">
                   <div class="row align-items-center">
                     <div class="col-icon">
                       <div
                         class="icon-big text-center icon-info bubble-shadow-small"
                       >
                         <i class="fas fa-user-check"></i>
                       </div>
                     </div>
                     <div class="col col-stats ms-3 ms-sm-0">
                       <div class="numbers">
                         <p class="card-category">Offres</p>
                         <h4 class="card-title"><?php echo $nbOffres?></h4>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-sm-6 col-md-3">
               <div class="card card-stats card-round">
                 <div class="card-body">
                   <div class="row align-items-center">
                     <div class="col-icon">
                       <div
                         class="icon-big text-center icon-success bubble-shadow-small"
                       >
                         <i class="fas fa-luggage-cart"></i>
                       </div>
                     </div>
                     <div class="col col-stats ms-3 ms-sm-0">
                       <div class="numbers">
                         <p class="card-category">Evénements</p>
                         <h4 class="card-title"><?php echo $nbEvents; ?></h4>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-sm-6 col-md-3">
               <div class="card card-stats card-round">
                 <div class="card-body">
                   <div class="row align-items-center">
                     <div class="col-icon">
                       <div
                         class="icon-big text-center icon-secondary bubble-shadow-small"
                       >
                         <i class="far fa-check-circle"></i>
                       </div>
                     </div>
                     <div class="col col-stats ms-3 ms-sm-0">
                       <div class="numbers">
                         <p class="card-category">Postes</p>
                         <h4 class="card-title">Nb postes</h4>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
           <div class="row">
           </div>
           <div class="row">
           </div>
           <div class="row">
           <div class="col-md-4">
           <div class="card card-round">
              <div class="card-body">
                <div class="card-head-row card-tools-still-right">
                  <div class="card-title">Nouveaux Utilisateurs</div>
                  <div class="card-tools">
                    <div class="dropdown"></div>
                  </div>
                </div>
                <div class="card-list py-4">
                  <?php if (is_array($users) && count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                      <div class="item-list">
                        <div class="avatar">
                        <?php if (!empty($user['profile_picture'])): ?>
                            <img 
                              src="data:image/jpeg;base64,<?= base64_encode($user['profile_picture']); ?>" 
                              alt="..." 
                              class="avatar-img rounded-circle" 
                            />
                          <?php else: ?>
                            <span class="avatar-title rounded-circle border border-white bg-secondary">
                              <?= strtoupper(substr(htmlspecialchars($user['name']), 0, 1)); ?>
                            </span>
                            <span class="avatar-title rounded-circle border border-white bg-secondary">
                              <?= strtoupper(substr(htmlspecialchars($user['nom']), 0, 1)); ?>
                            </span>
                          <?php endif; ?>
                        </div>
                        <div class="info-user ms-3">
                          <div class="username"><?= htmlspecialchars($user['nom']); ?></div>
                          <div class="username"><?= htmlspecialchars($user['prenom']); ?></div>
                          <div class="status">
                            <a href="mailto:<?= htmlspecialchars($user['mail']); ?>" class="text-decoration-none">
                              <?= htmlspecialchars($user['mail']); ?>
                            </a>
                          </div>                          
                          <div class="status"><?= htmlspecialchars($user['role']); ?></div>
                        </div>
                        <form method="POST" style="display: inline-block;">
                    <input type="hidden" name="id_user" value="<?= htmlspecialchars($user['id_users']); ?>">
                    <button type="submit" name="action" value="accept" class="btn btn-success btn-sm">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form method="POST" style="display: inline-block;">
                        <input type="hidden" name="id_user" value="<?= htmlspecialchars($user['id_users']); ?>">
                        <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i> 
                        </button>
                    </form>
                      </div>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <p>Aucun nouveaux utilisateurs</p>
                  <?php endif; ?>                 
                 </div>
               </div>
             </div>
           </div>
           <div class="col-md-8">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row card-tools-still-right">
                            <div class="card-title">Dernières Offres</div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <?php if (is_array($offers) && count($offers) > 0): ?>
                                <table class="table align-items-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Titre</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Salaire</th>
                                            <th scope="col" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($offers as $offer): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($offer['title_offers']); ?></td>
                                                <td><?= htmlspecialchars($offer['type_offers']); ?></td>
                                                <td>
                                                    <?= $offer['salary'] ? number_format($offer['salary'], 2, ',', ' ') . ' €' : 'Non précisé'; ?>
                                                </td>
                                                <td class="text-end">
                                                    <a href="details_offre.php?id=<?= $offer['id_offers']; ?>" 
                                                      class="btn btn-primary btn-sm">
                                                      Voir les détails
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <p class="text-center p-4">Aucune offre disponible</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

           </div>
         </div>
       </div>
     </div>


     <div class="custom-template">
       <div class="title">Settings</div>
       <div class="custom-content">
         <div class="switcher">
           <div class="switch-block">
             <h4>Couleur du Logo </h4>
             <div class="btnSwitch">
               <button
                 type="button"
                 class="selected changeLogoHeaderColor"
                 data-color="dark"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="blue"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="purple"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="light-blue"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="green"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="orange"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="red"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="white"
               ></button>
               <br />
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="dark2"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="blue2"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="purple2"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="light-blue2"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="green2"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="orange2"
               ></button>
               <button
                 type="button"
                 class="changeLogoHeaderColor"
                 data-color="red2"
               ></button>
             </div>
           </div>
           <div class="switch-block">
             <h4>Couleur de la navbar</h4>
             <div class="btnSwitch">
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="dark"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="blue"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="purple"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="light-blue"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="green"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="orange"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="red"
               ></button>
               <button
                 type="button"
                 class="selected changeTopBarColor"
                 data-color="white"
               ></button>
               <br />
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="dark2"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="blue2"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="purple2"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="light-blue2"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="green2"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="orange2"
               ></button>
               <button
                 type="button"
                 class="changeTopBarColor"
                 data-color="red2"
               ></button>
             </div>
           </div>
           <div class="switch-block">
             <h4>Sidebar</h4>
             <div class="btnSwitch">
               <button
                 type="button"
                 class="changeSideBarColor"
                 data-color="white"
               ></button>
               <button
                 type="button"
                 class="selected changeSideBarColor"
                 data-color="dark"
               ></button>
               <button
                 type="button"
                 class="changeSideBarColor"
                 data-color="dark2"
               ></button>
             </div>
           </div>
         </div>
       </div>
       <div class="custom-toggle">
         <i class="icon-settings"></i>
       </div>
     </div>
     <!-- End Custom template -->
   </div>
   <!--   Core JS Files   -->
   <script src="assets/js/core/jquery-3.7.1.min.js"></script>
   <script src="assets/js/core/popper.min.js"></script>
   <script src="assets/js/core/bootstrap.min.js"></script>


<!-- jQuery Scrollbar -->
<script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


<!-- Chart JS -->
<script src="assets/js/plugin/chart.js/chart.min.js"></script>


<!-- jQuery Sparkline -->
<script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>


<!-- Chart Circle -->
<script src="assets/js/plugin/chart-circle/circles.min.js"></script>


<!-- Datatables -->
<script src="assets/js/plugin/datatables/datatables.min.js"></script>


<!-- jQuery Vector Maps -->
<script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="assets/js/plugin/jsvectormap/world.js"></script>


<!-- Sweet Alert -->
<script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>


<!-- Kaiadmin JS -->
<script src="assets/js/kaiadmin.min.js"></script>


<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="assets/js/setting-demo.js"></script>
<script>
  $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#177dff",
    fillColor: "rgba(23, 125, 255, 0.14)",
  });


  $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#f3545d",
    fillColor: "rgba(243, 84, 93, .14)",
  });


  $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: "line",
    height: "70",
    width: "100%",
    lineWidth: "2",
    lineColor: "#ffa534",
    fillColor: "rgba(255, 165, 52, .14)",
  });
</script>
</body>
</html>