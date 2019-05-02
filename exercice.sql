-- 1/ rajouter un film 
INSERT INTO `movie` (`id`, `title`, `release_date`, `genre`, `duration`, `synopsis`, `producer`, `image`, `updated_at`)
VALUES (NULL, 'titre', '2019-05-01 00:00:00', 'Aventure', '145', 'synopsis', 'producteur', 'image.png', '2019-05-02 16:13:03'); 

-- 2/ récupérer tous les noms de films
SELECT `title` FROM `movie`;

-- 3/  récupérer les utilisateurs sans doublons 
SELECT DISTINCT `username` 
FROM `user`;

-- 4/ supprimer un film
DELETE FROM `movie` 
WHERE `movie`.`id` = 2;

-- 5/ mise à jour du nom d'un film
UPDATE `movie` 
SET `title` = 'Nouveau titre' 
WHERE `movie`.`id` = 2; 

-- 6/ liste des films triés par le nom 
SELECT * 
FROM `movie` 
ORDER BY `title`;

-- 7/ liste des films sortis entre 2018 et 2019 
SELECT * 
FROM `movie` 
WHERE `movie`.`release_date` 
BETWEEN '2018-01-01 00:00:00' 
AND '2019-31-12 23:59:59'; 

-- 8/ liste des utilisateurs avec un email gmail 
SELECT * 
FROM `user` 
WHERE `user`.`email` 
LIKE '%gmail%';

-- 9/ rajouter le champ pseudonyme à la table utilisateur
ALTER TABLE `user` 
ADD `test` VARCHAR(50);

-- 10/ récupérer les films sorties il y a deux ans et avec le nom qui commence par un "l"
SELECT * 
FROM `movie`
WHERE `movie`.`release_date` 
BETWEEN now() - interval 2 year 
AND NOW() 
AND `title` 
LIKE 'l%';

-- 11/ Créer une requête d'exemple pour chaque commande ci-dessous :
	-- A/ HAVING
		SELECT `user_id`, SUM(places) 
		FROM `booking` 
		GROUP BY `user_id`
		HAVING SUM(places) > 10;

	-- B/ SOUS-REQUETE
		SELECT *
		FROM `booking`
		WHERE `user_id` = (
		    SELECT `id`
		    FROM `user`
		    ORDER BY `username` DESC
		    LIMIT 1
		  );

	-- C/ RIGHT JOIN
		SELECT *
		FROM `user`
		RIGHT JOIN `booking` ON `user`.`id` = `booking`.`user_id`;
	-- D/ FULL JOIN
		SELECT *
		FROM `session`
		FULL JOIN `movie` ON `session`.`movie_id` = `movie`.`id`;
