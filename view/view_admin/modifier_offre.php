<?php
session_start();
include_once '../../repository/repositorySchumanConnect/OffersRepository.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
    $id_update = $_GET['id'];

    $offer = OffersRepository::find_offer_by_id($id_update);  

    if (!$offer) 
        echo "Aucune offre trouvée.";
} 
else
{
    echo 'Ne jouez pas svp !';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier l'Offre | SchumanConnect</title>
  <link rel="stylesheet" href="../../public/css/modifier_offre.css">
</head>
<body>
<!DOCTYPE html>

<?php
include_once '../../init.php';
include_once '../../utils/Bdd.php';
include_once '../../repository/repositoryAdmin/UsersRepository.php'; 
include_once '../../repository/repositoryAdmin/PostsRepository.php';
include_once '../../repository/repositoryAdmin/EventsRepository.php';
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


$usersNotAccepted = UsersRepository::getAllUsersNotAccepted();
$nbUsers = UsersRepository::getUsersNumber();
$nbPosts = PostsRepository::getPostsNumber();
$nbEvents = EventsRepository::getEventsNumber();

$users = UsersRepository::getUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_user'], $_POST['action'])) {
      $idUser = intval($_POST['id_user']);
      $action = ($_POST['action'] === 'accept') ? 1 : 0; // ternaire pris d'internet et j'ai readapter pour moi

      UsersRepository::rejectOrAcceptedCandidat($idUser, $action);

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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



   <!-- Fonts and icons -->
   <script src="../../view/view_admin/assets/js/plugin/webfont/webfont.min.js"></script>
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
   <link rel="stylesheet" href="../../view/view_admin/assets/css/bootstrap.min.css" />
   <link rel="stylesheet" href="../../view/view_admin/assets/css/plugins.min.css" />
   <link rel="stylesheet" href="../../view/view_admin/assets/css/kaiadmin.min.css" />


 </head>
   <div class="wrapper">
     <!-- Sidebar -->
     <div class="sidebar" data-background-color="dark">
       <div class="sidebar-logo">
         <!-- Logo Header -->
         <div class="logo-header" data-background-color="dark">
           <a href="../../view/view_admin/index.php" class="logo">
             <img
               src="https://lyceerobertschuman.fr/wp-content/uploads/2021/11/Logo-New-RS.png"
               alt="navbar brand"
               class="navbar-brand"
               height="20"
            />
           </a>
           <div class="nav-toggle">
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
                 href="../../view/view_admin/index.php"
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
               <a href="../../view/view_admin/users.php">
                 <i class="fas fa-users"></i>
                 <p>Utilisateurs</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="../../view/view_admin/offers.php">
                 <i class="fas fa-briefcase"></i>
                 <p>Offres</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="../../view/view_admin/events.php">
                 <i class="fas fa-calendar-alt"></i>
                 <p>Evénements</p>
               </a>
             </li>
             <li class="nav-item">
               <a href="#entreprise" data-toggle="collapse">
                 <i class="fas fa-building"></i>
                 <p>Entreprises</p>
                 <span class="caret"></span>
               </a>

               <div class="collapse" id="entreprise">
                 <ul class="nav nav-collapse">
                   <li>
                     <a href="../../view/view_admin/society_partner.php">
                       <span class="sub-item">Entreprises Partenaires</span>
                     </a>
                   </li>
                   <li>
                     <a href="../../view/view_admin/messagerie.php">
                       <span class="sub-item">Mes Messages</span>
                     </a>
                   </li>
                   <li>
                     <a href="../../view/view_admin/messages.php">
                       <span class="sub-item">Messages</span>
                     </a>
                   </li>
                 </ul>
               </div>
             </li>
             <li class="nav-item">
               <a href="../../view/view_admin/posts.php">
                 <i class="fas fa-building"></i>
                 <p>Posts</p>
               </a>
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
             <a href="../../view/view_admin/index.php" class="logo">
               <img
                 src="https://www.illinoisworknet.com/DownloadPrint/IWN2018_icon-homedashboard_IWNOrange.png"
                 alt="navbar brand"
                 class="navbar-brand"
                 height="40"
              />
             </a>
             <div class="nav-toggle">
             </div>
           </div>
           <!-- End Logo Header -->
         </div>
         <!-- Navbar Header -->
         <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
           <div class="container-fluid">
             <nav
               class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
             >


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
                data-toggle="collapse"
                href="#profileMenu"
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
                <ul class="dropdown-menu dropdown-user collapse" id="profileMenu">
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
                            href="../../view/view_etudiants/profil.php"
                            class="btn btn-xs btn-secondary btn-sm"
                        >Gérer mon Profil</a>
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
       <script src="../../view/view_admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


<!-- Chart JS -->
<script src="../../view/view_admin/assets/js/plugin/chart.js/chart.min.js"></script>


<!-- jQuery Sparkline -->
<script src="../../view/view_admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>


<!-- Chart Circle -->
<script src="../../view/view_admin/assets/js/plugin/chart-circle/circles.min.js"></script>


<!-- Datatables -->
<script src="../../view/view_admin/assets/js/plugin/datatables/datatables.min.js"></script>


<!-- jQuery Vector Maps -->
<script src="../../view/view_admin/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="../../view/view_admin/assets/js/plugin/jsvectormap/world.js"></script>


<!-- Sweet Alert -->
<script src="../../view/view_admin/assets/js/plugin/sweetalert/sweetalert.min.js"></script>


<!-- Kaiadmin JS -->
<script src="../../view/view_admin/assets/js/kaiadmin.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.querySelector('[data-toggle="collapse"][href="#entreprise"]');
    const collapseDiv = document.querySelector('#entreprise');

    if (toggleButton && collapseDiv) {
      toggleButton.addEventListener("click", function (e) {
        e.preventDefault();
        const isCollapsed = collapseDiv.classList.contains("show");
        if (isCollapsed) {
          collapseDiv.classList.remove("show");
        } else {
          collapseDiv.classList.add("show");
        }
      });
    }
  });
</script>
<script>
  $(document).ready(function () {
    $('[data-toggle="collapse"]').on('click', function (e) {
      e.preventDefault();
      const target = $(this).attr('href');
      $(target).toggleClass('show');
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const profileToggle = document.querySelector('.dropdown-toggle.profile-pic');
    const profileMenu = document.querySelector('#profileMenu');

    if (profileToggle && profileMenu) {
      profileToggle.addEventListener('click', function (e) {
        e.preventDefault();
        profileMenu.classList.toggle('show');
      });
    }
  });
</script>
<script>
  $(document).ready(function () {
    $('.dropdown-toggle.profile-pic').on('click', function (e) {
      e.preventDefault();
      $('#profileMenu').toggleClass('show');
    });
  });
</script>

  <div class="container">
    <div class="profile-header">
      <h1>Modifier l'Offre</h1>
      <p>Modifiez les détails de l'offre ci-dessous.</p>
    </div>


    <div class="form-section">
      <form action="../../controller/controllerBusiness/process_modifier_offre_admin.php" method="post">
      <input type="hidden" name="id_offers_update" value="<?php echo htmlspecialchars($_GET['id']); ?>">
        <div class="form-group">
          <label for="title_offers">Titre de l'Offre</label>
          <input type="text" id="title_offers" name="title_offers" value="<?php echo htmlspecialchars($offer['title_offers']); ?>" required>
        </div>

        <div class="form-group">
          <label for="describe_offers">Description</label>
          <textarea id="describe_offers" name="describe_offers" required><?php echo htmlspecialchars($offer['describe_offers']); ?></textarea>
        </div>

        <div class="form-group">
          <label for="mission">Mission</label>
          <textarea id="mission" name="mission" required><?php echo htmlspecialchars($offer['mission']); ?></textarea>
        </div>

        <div class="form-group">
          <label for="type_offers">Type de Contrat</label>
          <select id="type_offers" name="type_offers" required>
            <option value="stage" <?php if ($offer['type_offers'] == 'stage') echo 'selected'; ?>>Stage</option>
            <option value="alternance" <?php if ($offer['type_offers'] == 'alternance') echo 'selected'; ?>>Alternance</option>
            <option value="cdd" <?php if ($offer['type_offers'] == 'cdd') echo 'selected'; ?>>CDD</option>
            <option value="cdi" <?php if ($offer['type_offers'] == 'cdi') echo 'selected'; ?>>CDI</option>
          </select>
        </div>

        <div class="form-group">
          <label for="salary">Salaire</label>
          <input type="number" id="salary" name="salary" value="<?php echo htmlspecialchars($offer['salary']); ?>" required>
        </div>

        <div class="form-group">
          <label for="degrees">Diplôme requis</label>
          <select id="degrees" name="degrees" required>
          <option value="Bac+1" <?php if ($offer['degrees'] == 'Bac+1') echo 'selected'; ?>>Bac+1</option>
          <option value="Bac+2" <?php if ($offer['degrees'] == 'Bac+2') echo 'selected'; ?>>Bac+2</option>
          <option value="Bac+3" <?php if ($offer['degrees'] == 'Bac+3') echo 'selected'; ?>>Bac+3</option>
          <option value="Bac+4" <?php if ($offer['degrees'] == 'Bac+4') echo 'selected'; ?>>Bac+4</option>
          <option value="Bac+5" <?php if ($offer['degrees'] == 'Bac+5') echo 'selected'; ?>>Bac+5</option>

        </select>
        </div>

        <div class="form-group">
          <label for="disponible">Statut</label>
          <select id="disponible" name="disponible" required>
            <option value="1" <?php if ($offer['disponible'] == 1) echo 'selected'; ?>>Laisser l'offre disponible</option>
            <option value="0" <?php if ($offer['disponible'] == 0) echo 'selected'; ?>>Fermé l'acces à l'offre</option>
          </select>
        </div>

        <div class="form-actions">
          <button type="submit" name="edit_offer" class="btn btn-save">Sauvegarder les modifications</button>
          <button type="button" class="btn btn-cancel" onclick="window.location.href='./offers.php'">Annuler</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
