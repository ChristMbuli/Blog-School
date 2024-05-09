<?php require '../backend/NewPost.php';

require '../backend/AllPost.php';
?>
<div class="bg-white p-8 rounded-lg shadow-md ">
    <div class="flex items-center justify-between mb-5">
        <form action="" class="bg-white w-full shadow rounded-lg p-5" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="titre" name="title"
                class="bg-white-200 w-full rounded-lg shadow border p-2 mb-4">
            <textarea id="message" class="bg-white-200 w-full rounded-lg shadow border p-2" name="description" rows="3"
                placeholder="Commencer un post" oninput="toggleButtonVisibility()"></textarea>

            <div class="w-full flex justify-between items-center flex-row flex-wrap mt-3">
                <div class="cursor-pointer">
                    <label for="file-input" class="cursor-pointer">
                        <i class="fa-regular fa-image text-blue-700 cursor-pointer"></i> <span
                            class="text-gray-600 font-bold">Medias</span>
                    </label>
                    <input id="file-input" type="file" name="media[]" multiple accept="image/*,video/*"
                        style="display: none; cursor:pointer">
                </div>

                <div class="w-2/3">
                    <button type="submit" name="send" id="commentButton"
                        class="float-right bg-indigo-400 hover:bg-indigo-300 text-white p-2 rounded-lg"
                        style="display: none;">Publier</button>
                </div>
            </div>
            <!-- Alerte -->
            <?php $alertPath = __DIR__ . DIRECTORY_SEPARATOR . 'alerte.php';
            require_once $alertPath;
            ?>
        </form>

    </div>
    <?php while ($row = $query->fetch()) { ?>
    <div class="bg-white p-8 mb-5 rounded-lg shadow-md">
        <!-- User Info with Three-Dot Menu -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <?php
                    // Tableau de classes CSS de couleurs prédéfinies
                    $backgroundColors = [
                        'bg-blue-500',
                        'bg-red-500',
                        'bg-green-500',
                        'bg-yellow-500',
                        'bg-purple-500',
                        'bg-indigo-500',
                        'bg-pink-500',
                        'bg-teal-500',
                        'bg-orange-500',
                        'bg-gray-500',
                    ];

                    // Fonction pour calculer un index déterministe basé sur l'identifiant ou le prénom de l'utilisateurif (!function_exists('getColorIndex')) {
                    if (!function_exists('getColorIndex')) {
                        function getColorIndex($identifier, $colorsCount)
                        {
                            // Calculer la valeur de hachage de l'identifiant
                            $hash = crc32($identifier);

                            // Utiliser le module pour obtenir un index de couleur entre 0 et (colorsCount - 1)
                            return abs($hash % $colorsCount);
                        }
                    }

                    // Identifier unique (par exemple, l'identifiant de l'étudiant ou le prénom)
                    $identifier = $row['fname']; // Utilisez l'identifier approprié
                
                    // Obtenir l'index de la couleur basée sur l'identifiant
                    $colorIndex = getColorIndex($identifier, count($backgroundColors));

                    // Sélectionner la couleur en fonction de l'index calculé
                    $selectedColor = $backgroundColors[$colorIndex];

                    // Vérifiez si le profil est null
                    if (is_null($row['profil']) || $row['profil'] === null) {
                        // Extraire les initiales du prénom
                        $initials = strtoupper(substr($row['fname'], 0, 1)); // Première lettre
                        if (strlen($row['fname']) > 1) {
                            $initials .= strtoupper(substr($row['fname'], 1, 1)); // Deuxième lettre
                        }

                        // Afficher les initiales avec la couleur de fond calculée
                        echo '<div class="w-8 h-8 rounded-full flex items-center justify-center ' . $selectedColor . ' text-white font-bold">';
                        echo $initials;
                        echo '</div>';
                    } else {
                        // Afficher l'image de profil
                        echo '<img src="' . $row['profil'] . '" alt="User Avatar" class="w-8 h-8 rounded-full">';
                    }
                    ?>

                <div>
                    <p class="text-gray-800 font-semibold"><?= $row['fname'] ?></p>
                    <!-- Date -->
                    <?php
                        // Récupérer la date stockée dans la base de données
                        $createdAt = $row['date_publication'];

                        // Convertir la date en objet DateTime
                        $dateCreated = new DateTime($createdAt);

                        // Obtenir la date et l'heure actuelle
                        $currentDate = new DateTime();

                        // Calculer la différence entre les deux dates
                        $interval = $dateCreated->diff($currentDate);

                        // Initialiser le message
                        $timeElapsedMessage = '';

                        // Calculer le temps écoulé de manière dynamique
                        if ($interval->y > 0) {
                            // Années écoulées
                            $timeElapsedMessage = $interval->y . ' an' . ($interval->y > 1 ? 's' : '') . ' ';
                        } elseif ($interval->m > 0) {
                            // Mois écoulés
                            $timeElapsedMessage = $interval->m . ' mois ';
                        } elseif ($interval->d >= 7) {
                            // Semaines écoulées
                            $weeks = floor($interval->d / 7);
                            $timeElapsedMessage = $weeks . ' semaine' . ($weeks > 1 ? 's' : '') . ' ';
                        } elseif ($interval->d > 0) {
                            // Jours écoulés
                            $timeElapsedMessage = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '') . ' ';
                        } elseif ($interval->h > 0) {
                            // Heures écoulées
                            $timeElapsedMessage = $interval->h . ' heure' . ($interval->h > 1 ? 's' : '') . ' ';
                        } elseif ($interval->i > 0) {
                            // Minutes écoulées
                            $timeElapsedMessage = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ';
                        } else {
                            // Secondes écoulées
                            $timeElapsedMessage = $interval->s . ' seconde' . ($interval->s > 1 ? 's' : '') . ' ';
                        }

                        // Afficher la durée écoulée
                        echo '<p class="text-gray-500 text-sm">Publié il y a ' . htmlspecialchars($timeElapsedMessage) . '</p>';
                        ?>

                </div>
            </div>
            <div class="text-gray-500 cursor-pointer">
                <!-- Three-dot menu icon -->
                <button class="hover:bg-gray-50 rounded-full p-1">
                    <i class="fa-solid fa-plus"></i> Suivre
                </button>
            </div>
        </div>

        <!-- Image -->
        <div class="mb-4">
            <a href="single.php?id=<?= htmlspecialchars($row['id']) ?>">
                <?php if ($row['media_type'] === 'image'): ?>
                <img src="<?= htmlspecialchars($row['media_url']) ?>" alt="Post Image"
                    class="w-full h-58 object-cover rounded-md">
                <?php elseif ($row['media_type'] === 'video'): ?>
                <video src="<?= htmlspecialchars($row['media_url']) ?>" controls
                    class="w-full h-58 object-cover rounded-md"></video>
                <?php endif; ?>
            </a>


        </div>
        <!-- Like and Comment Section -->
        <div class="flex items-center justify-between text-gray-500">
            <div class="flex items-center space-x-2">
                <button class="flex justify-center items-center gap-2 px-2 hover:bg-gray-50 rounded-full p-1">
                    <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M12 21.35l-1.45-1.32C6.11 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-4.11 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    <span>42</span>
                </button>
            </div>
            <button class="flex justify-center items-center gap-2 px-2 hover:bg-gray-50 rounded-full p-1">
                <svg width="22px" height="22px" viewBox="0 0 24 24" class="w-5 h-5 fill-current"
                    xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                    </g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22ZM8 13.25C7.58579 13.25 7.25 13.5858 7.25 14C7.25 14.4142 7.58579 14.75 8 14.75H13.5C13.9142 14.75 14.25 14.4142 14.25 14C14.25 13.5858 13.9142 13.25 13.5 13.25H8ZM7.25 10.5C7.25 10.0858 7.58579 9.75 8 9.75H16C16.4142 9.75 16.75 10.0858 16.75 10.5C16.75 10.9142 16.4142 11.25 16 11.25H8C7.58579 11.25 7.25 10.9142 7.25 10.5Z">
                        </path>
                    </g>
                </svg>
                <span>3 Commentaires</span>
            </button>
        </div>
    </div>
    <?php } ?>

</div>

<script>
function toggleButtonVisibility() {
    const textarea = document.getElementById('message');
    const button = document.getElementById('commentButton');

    if (textarea.value.trim() === '') {
        button.style.display = 'none';
    } else {
        button.style.display = 'inline-block';
    }
}
</script>