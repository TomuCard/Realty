-- SQLBook: Code
-- sudo mysql -u root
-- CREATE DATABASE realty;
-- use realty
-- CREATE USER 'realty' IDENTIFIED BY 'realty';
-- GRANT ALL PRIVILEGES ON realty.* TO 'realty' WITH GRANT OPTION;
-- FLUSH PRIVILEGES;

-- Linux :
-- mysql -u realty  -p realty  < ./data/realty.sql

-- Windows :
-- type .\data\realty.sql | mysql -u realty -p realty   

BEGIN;

DROP TABLE IF EXISTS 
`apartment`, 
`user`, 
`user_problem`, 
`user_invoice`, 
`apartment_rental`, 
`apartment_service`, 
`user_favorite`, 
`user_planning`, 
`apartment_check`, 
`employee_report`,
`service`,
`apartment_employee`,
`user_review`,
`comment_progress`,
`notification`,
`notification_message` 
CASCADE;

CREATE TABLE `apartment` (
  apartment_id INT PRIMARY KEY AUTO_INCREMENT,
  apartment_title VARCHAR(255),
  apartment_description TEXT,
  apartment_main_picture VARCHAR(255),
  apartment_360_picture VARCHAR(255),
  apartment_adress VARCHAR(255),
  apartment_zip_code INT,
  apartment_city VARCHAR(255),
  apartment_price FLOAT,
  apartment_size INT,
  apartment_bedroom INT,
  apartment_capacity INT,
  apartment_is_free INT NOT NULL DEFAULT 1,
  apartment_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  apartment_updated_at timestamp
);

CREATE TABLE `user` (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  user_firstname VARCHAR(255),
  user_lastname VARCHAR(255),
  user_birth date,
  user_password VARCHAR(255),
  user_phone VARCHAR(255),
  user_address VARCHAR(255),
  user_zip_code VARCHAR(255),
  user_city VARCHAR(255),
  user_mail VARCHAR(255) UNIQUE,
  user_statut VARCHAR(255) DEFAULT "Client",
  user_active INT DEFAULT 1,
  user_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  user_updated_at timestamp
);

CREATE TABLE `user_problem` (
  user_problem_id INT PRIMARY KEY AUTO_INCREMENT,
  user_problem_user_id INT,
  user_problem_apartment_id INT,
  user_problem_description TEXT,
  user_problem_date date,
  user_problem_statut VARCHAR(255) DEFAULT 'In progress',
  FOREIGN KEY (user_problem_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (user_problem_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  user_problem_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  user_problem_updated_at timestamp
);

CREATE TABLE `user_invoice` (
  user_invoice_id INT PRIMARY KEY AUTO_INCREMENT,
  user_invoice_user_id INT,
  user_invoice_apartment_id INT,
  user_invoice_date date,
  user_invoice_amount FLOAT,
  FOREIGN KEY (user_invoice_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (user_invoice_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  user_invoice_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  user_invoice_updated_at timestamp
);

CREATE TABLE `apartment_rental` (
  apartment_rental_id INT PRIMARY KEY AUTO_INCREMENT,
  apartment_rental_user_id INT,
  apartment_rental_apartement_id INT,
  apartment_rental_start date,
  apartment_rental_end date,
  FOREIGN KEY (apartment_rental_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (apartment_rental_apartement_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  apartment_rental_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  apartment_rental_updated_at timestamp
);

CREATE TABLE `service` (
  service_id INT PRIMARY KEY AUTO_INCREMENT,
  service_name VARCHAR(255),
  apartment_service_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  apartment_service_updated_at timestamp
);

CREATE TABLE `apartment_service` (
  apartment_service_id INT PRIMARY KEY AUTO_INCREMENT,
  apartment_service_service_id INT,
  apartment_service_apartment_id INT,
  FOREIGN KEY (apartment_service_service_id) REFERENCES service(service_id) ON DELETE CASCADE,
  FOREIGN KEY (apartment_service_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  apartment_service_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  apartment_service_updated_at timestamp
);

CREATE TABLE `user_planning` (
  user_planning_id INT PRIMARY KEY AUTO_INCREMENT,
  user_planning_user_id INT,
  user_planning_apartment_id INT,
  user_planning_date date,
  FOREIGN KEY (user_planning_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (user_planning_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  user_planning_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  user_planning_updated_at timestamp
);

CREATE TABLE `apartment_employee` (
  apartment_employee_id INT PRIMARY KEY AUTO_INCREMENT,
  apartment_employee_apartment_id INT,
  apartment_employee_menage_user_id INT,
  apartment_employee_logistique_user_id INT,
  FOREIGN KEY (apartment_employee_menage_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (apartment_employee_logistique_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (apartment_employee_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  apartment_employee_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  apartment_employee_updated_at timestamp
);

CREATE TABLE `apartment_check` (
  apartment_check_id INT PRIMARY KEY AUTO_INCREMENT,
  apartment_check_apartment_id INT,
  apartment_check_task VARCHAR(255),
  apartment_check_statut VARCHAR(255) DEFAULT 'In progress',
  FOREIGN KEY (apartment_check_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  apartment_check_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  apartment_check_updated_at timestamp
);

CREATE TABLE `user_review` (
  user_review_id INT PRIMARY KEY AUTO_INCREMENT,
  user_review_user_id INT,
  user_review_apartment_id INT,
  user_review_comment VARCHAR(255),
  FOREIGN KEY (user_review_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (user_review_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  user_review_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  user_review_updated_at timestamp
);

CREATE TABLE `comment_progress` (
  comment_progress_id INT PRIMARY KEY AUTO_INCREMENT,
  comment_progress_user_id INT,
  comment_progress_apartment_id INT,
  comment_progress_comment VARCHAR(255),
  FOREIGN KEY (comment_progress_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (comment_progress_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  comment_progress_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  comment_progress_updated_at timestamp
);

CREATE TABLE `notification` (
  notification_id INT PRIMARY KEY AUTO_INCREMENT,
  notification_user_logistic_id INT,
  notification_apartment_id INT,
  notification_message VARCHAR(255),
  notification_link VARCHAR(255),
  notification_comment_id INT,
  FOREIGN KEY (notification_user_logistic_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (notification_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  FOREIGN KEY (notification_comment_id) REFERENCES comment_progress(comment_progress_id) ON DELETE CASCADE,
  notification_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  notification_updated_at timestamp
);

CREATE TABLE `notification_message` (
  notification_message_id INT PRIMARY KEY AUTO_INCREMENT,
  notification_message_user_logistic_id INT,
  notification_message_apartment_id INT,
  notification_message_message VARCHAR(255),
  notification_message_link VARCHAR(255),
  notification_message_user_problem_id INT,
  FOREIGN KEY (notification_message_user_logistic_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (notification_message_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  FOREIGN KEY (notification_message_user_problem_id) REFERENCES user_problem(user_problem_id) ON DELETE CASCADE,
  notification_message_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  notification_message_updated_at timestamp
);

CREATE TABLE `employee_report` (
  employee_report_id INT PRIMARY KEY AUTO_INCREMENT,
  employee_report_user_id INT,
  employee_report_apartment_id INT,
  employee_report_logistics_user_id INT,
  employee_report_message VARCHAR(255),
  employee_report_date date,
  FOREIGN KEY (employee_report_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (employee_report_logistics_user_id) REFERENCES user(user_id) ON DELETE CASCADE,
  FOREIGN KEY (employee_report_apartment_id) REFERENCES apartment(apartment_id) ON DELETE CASCADE,
  employee_report_created_at timestamp DEFAULT CURRENT_TIMESTAMP,
  employee_report_updated_at timestamp
);

INSERT INTO `apartment`(
    `apartment_title`,
    `apartment_description`,
    `apartment_main_picture`,
    `apartment_360_picture`,
    `apartment_adress`,
    `apartment_zip_code`,
    `apartment_city`,
    `apartment_price`,
    `apartment_size`,
    `apartment_bedroom`,
    `apartment_capacity`
) VALUES 
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/magazine/wp-content/uploads/2015/10/vue-tour-eiffel-643x429.jpg',
    'http://localhost:4000/images/pano1.jpg',
    'Avenue D''Iéna',
    75016,
    'Paris',
    1000,
    60,
    4,
    5
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/photo/paris/14622/img-2023-5-12-183922.webp',
    'http://localhost:4000/images/pano2.jpg',
    'rue Poussin, à Auteuil',
    75016,
    'Paris',
    900,
    40,
    3,
    4
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/photo/paris/20992/salon1.webp',
    'http://localhost:4000/images/pano3.jpg',
    'Quai de Grenelle',
    75015,
    'Paris',
    500,
    30,
    3,
    4
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/photo/paris/22819/img-2023-5-25-145914.jpg',
    'http://localhost:4000/images/pano4.jpg',
    'Rue Saint Placide',
    75016,
    'Paris',
    1500,
    100,
    10,
    11
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/magazine/wp-content/uploads/2015/11/rivoli-tuileries-1024x683.jpg',
    'http://localhost:4000/images/pano5.jpg',
    'Rue de Rivoli',
    75001,
    'Paris',
    1200,
    85,
    7,
    8
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/magazine/wp-content/uploads/2015/11/appartement-rue-de-l_oratoire.jpg',
    'http://localhost:4000/images/pano6.jpg',
    'Quartier Louvre',
    75001,
    'Paris',
    2000,
    105,
    10,
    11
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/photo/paris/19900/img-2023-5-14-162817.webp',
    'http://localhost:4000/images/pano7.jpg',
    'Rue de la Tremoille',
    75018,
    'Paris',
    1500,
    90,
    10,
    11
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/photo/paris/16512/16512-salon2.webp',
    'http://localhost:4000/images/pano8.jpg',
    'Rue passy',
    75016,
    'Paris',
    800,
    70,
    5,
    6
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/magazine/wp-content/uploads/2015/11/salon-suffren-paris.jpg',
    'http://localhost:4000/images/pano9.jpg',
    'champs de mars',
    75015,
    'Paris',
    750,
    65,
    3,
    4
),
(
    'Location',
    'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
    'https://www.book-a-flat.com/photo/paris/18631/salon.webp',
    'http://localhost:4000/images/pano10.jpg',
    'Rue Saint Honoré',
    75001,
    'Paris',
    850,
    75,
    4,
    5
);

INSERT INTO `user` (
    `user_firstname`,
    `user_lastname`,
    `user_birth`,
    `user_password`,
    `user_phone`,
    `user_address`,
    `user_zip_code`,
    `user_city`,
    `user_mail`,
    `user_statut`

) VALUES 
(
    'Kevin',
    'Bernard',
    '2004/07/10',
    '$2a$12$9LQALo1pqUqZeHK4t0vLpOI5m.BZV9hxW2GfrtoI/lSa68edXB1Mi',
    '06-00-00-00-00',
    '5 rue du mancho',
    '42000',
    'saint étienne',
    'kevin.bernard@gmail.com',
    'Client'
),
(
    'William',
    'Vandal',
    '1990/09/29',
    '$2a$12$9LQALo1pqUqZeHK4t0vLpOI5m.BZV9hxW2GfrtoI/lSa68edXB1Mi',
    '06-00-00-00-00',
    '5 rue du mancho',
    '42000',
    'saint étienne',
    'vandal.william@gmail.com',
    'Logistique'
),
(
    'Mohamed',
    'Yaich',
    '2001/12/07',
    '$2a$12$9LQALo1pqUqZeHK4t0vLpOI5m.BZV9hxW2GfrtoI/lSa68edXB1Mi',
    '06-00-00-00-00',
    '5 rue du mancho',
    '42000',
    'saint étienne',
    'mohamed.yaich@gmail.com',
    'Client'
),
(
    'Lucas',
    'Yalman',
    '2004/08/20',
    '$2a$12$9LQALo1pqUqZeHK4t0vLpOI5m.BZV9hxW2GfrtoI/lSa68edXB1Mi',
    '06-00-00-00-00',
    '5 rue du mancho',
    '42000',
    'saint étienne',
    'lucas.yalman@gmail.com',
    'Admin'
),
(
    'Tom',
    'Cardonnel',
    '2003/06/18',
    '$2a$12$9LQALo1pqUqZeHK4t0vLpOI5m.BZV9hxW2GfrtoI/lSa68edXB1Mi',
    '06-00-00-00-00',
    '5 rue du mancho',
    '42000',
    'saint étienne',
    'tom.cardonnel@gmail.com',
    'Menage'
),
(
    'Rubens',
    'Bonnin',
    '2004/06/21',
    '$2a$12$9LQALo1pqUqZeHK4t0vLpOI5m.BZV9hxW2GfrtoI/lSa68edXB1Mi',
    '06-00-00-00-00',
    '5 rue du mancho',
    '42000',
    'saint étienne',
    'Rubens.Bonnin@gmail.com',
    'Menage'
),
(
    'Alexendre',
    'Cardonnel',
    '2004/06/21',
    '$2a$12$9LQALo1pqUqZeHK4t0vLpOI5m.BZV9hxW2GfrtoI/lSa68edXB1Mi',
    '06-00-00-00-00',
    '5 rue du mancho',
    '42000',
    'saint étienne',
    'alexendre.cardonnel@gmail.com',
    'Logistique'
);

-- Appartements


INSERT INTO `apartment_rental` (
    `apartment_rental_user_id`,
    `apartment_rental_apartement_id`,
    `apartment_rental_start`,
    `apartment_rental_end`

) VALUES 
(1, 2, '2023/06/01', '2023/06/10'),
(1, 2, '2023/06/15', '2023/06/26'),
(3, 1, '2023/07/10', '2023/07/17'),
(1, 3, '2023/07/20', '2023/07/27'),
(3, 4, '2023/08/01', '2023/08/07'),
(1, 5, '2023/08/10', '2023/08/17'),
(3, 6, '2023/08/20', '2023/08/27');

INSERT INTO `service` (
    `service_name`

) VALUES 
('Vue sur le canal'),
('Front de mer'),
('Espace de travail dédié'),
('Baignoire'),
('Cheminée'),
('Vue panoramique sur la ville'),
('Wifi'),
('Ascenseur'),
('Patio ou balcon : privé(e)'),
('Caméras de surveillance extérieure et/ou dans les espaces communs');

INSERT INTO `apartment_service` (
    `apartment_service_apartment_id`,
    `apartment_service_service_id`

) VALUES 
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 1),
(2, 2),
(2, 8),
(2, 9),
(2, 6),
(3, 6),
(3, 5),
(3, 3),
(3, 2),
(3, 8),
(4, 7),
(4, 4),
(4, 2),
(4, 3),
(4, 10),
(5, 1),
(5, 5),
(5, 8),
(5, 10),
(5, 3),
(6, 5),
(6, 1),
(6, 2),
(6, 10),
(6, 1),
(7, 5),
(7, 3),
(7, 2),
(7, 1),
(7, 9),
(8, 1),
(8, 5),
(8, 8),
(8, 9),
(8, 10),
(9, 3),
(9, 4),
(9, 5),
(9, 6),
(9, 7),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(10, 7),
(10, 8),
(10, 9),
(10, 10);

INSERT INTO `apartment_employee`(
`apartment_employee_apartment_id`,
`apartment_employee_menage_user_id`,
`apartment_employee_logistique_user_id`

) VALUES 
(1, 5, 2),
(2, 5, 2),
(3, 5, 2),
(4, 5, 2),
(5, 5, 2),
(6, 6, 7),
(7, 6, 7),
(8, 6, 7),
(9, 6, 7),
(10, 6, 7);

INSERT INTO `apartment_check` (
    `apartment_check_apartment_id`,
    `apartment_check_task`

) VALUES 
(2, 'Vérifier l''eau chaude'),
(2, 'Vérifier les piles dans la télécomande'),
(2, 'Vérifier l''état des toilette'),
(2, 'Vérifier le linge de maison'),
(2, 'Vérifier l''état du climatiseur'),
(1, 'Vérifier l''eau chaude'),
(1, 'Vérifier les piles dans la télécomande'),
(1, 'Vérifier l''état des toilette'),
(1, 'Vérifier le linge de maison'),
(1, 'Vérifier l''état du climatiseur'),
(3, 'Vérifier l''eau chaude'),
(3, 'Vérifier les piles dans la télécomande'),
(3, 'Vérifier l''état des toilette'),
(3, 'Vérifier le linge de maison'),
(3, 'Vérifier l''état du climatiseur'),
(4, 'Vérifier l''eau chaude'),
(4, 'Vérifier les piles dans la télécomande'),
(4, 'Vérifier l''état des toilette'),
(4, 'Vérifier le linge de maison'),
(4, 'Vérifier l''état du climatiseur'),
(5, 'Vérifier l''eau chaude'),
(5, 'Vérifier les piles dans la télécomande'),
(5, 'Vérifier l''état des toilette'),
(5, 'Vérifier le linge de maison'),
(5, 'Vérifier l''état du climatiseur'),
(6, 'Vérifier l''eau chaude'),
(6, 'Vérifier les piles dans la télécomande'),
(6, 'Vérifier l''état des toilette'),
(6, 'Vérifier le linge de maison'),
(6, 'Vérifier l''état du climatiseur');

-- USER
-- 1, 3 = client
-- 5, 6 = ménage

INSERT INTO `user_problem` (
    `user_problem_user_id`,
    `user_problem_apartment_id`,
    `user_problem_description`,
    `user_problem_date`

) VALUES 
(1, 2, 'les rideaux sont déchirer', '2023/07/02'),
(2, 2, 'un technicien viendra les remplacer ce jour', '2023/07/02'),
(3, 1, 'il n''y a plus d''eau chaude', '2023/07/11'),
(7, 1, 'un technicien viendra les remplacer ce jour', '2023/07/02');


INSERT INTO `user_invoice` (
    `user_invoice_user_id`,
    `user_invoice_apartment_id`,
    `user_invoice_date`,
    `user_invoice_amount`

) VALUES 
(1, 2, '2023/06/06', 5400),
(3, 1, '2023/06/05', 6000),
(1, 3, '2023/06/02', 3000),
(3, 4, '2023/06/01', 9000),
(1, 5, '2023/06/03', 7200),
(3, 6, '2023/06/04', 12000);

INSERT INTO `user_planning` (
`user_planning_user_id`,
`user_planning_apartment_id`,
`user_planning_date`
) VALUES 
(5, 2, '2023/06/29'),
(5, 1, '2023/07/08'),
(5, 3, '2023/07/18'),
(5, 4, '2023/07/28'),
(5, 5, '2023/08/18'),
(6, 6, '2023/08/28');

INSERT INTO `user_review` (
`user_review_user_id`,
`user_review_apartment_id`,
`user_review_comment`
) VALUES 
(1, 2, 'Génial j''ai aimé mon séjour du debut a la fin'),
(1, 3, 'service impécable');


INSERT INTO `employee_report` (
`employee_report_user_id`,
`employee_report_apartment_id`,
`employee_report_logistics_user_id`,
`employee_report_message`,
`employee_report_date`
) VALUES 
(5, 1, 7, 'il n''y a plus d''eau chaude', '2023/07/08');

COMMIT;