<?php
// Afficher les erreurs dans le navigateur
require_once './debug.php';


// apartment
require_once './routes/apartmentRoutes/apartment_checkRoute.php';
require_once './routes/apartmentRoutes/apartment_employeeRoute.php';
require_once './routes/apartmentRoutes/apartment_rentalRoute.php';
require_once './routes/apartmentRoutes/apartment_serviceRoute.php';
require_once './routes/apartmentRoutes/apartmentRoute.php';
require_once './routes/apartmentRoutes/serviceRoute.php';

// user
require_once './routes/userRoutes/employee_reportRoute.php';
require_once './routes/userRoutes/user_favoriteRoute.php';
require_once './routes/userRoutes/user_invoiceRoute.php';
require_once './routes/userRoutes/user_planningRoute.php';
require_once './routes/userRoutes/user_problemRoute.php';
require_once './routes/userRoutes/user_reviewRoute.php';
require_once './routes/userRoutes/userCommentProgressRoute.php';
require_once './routes/userRoutes/userRoute.php';
