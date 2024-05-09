<?php require '../backend/NewPost.php';

require '../backend/AllPost.php';
?>
<div class="bg-white p-8 rounded-lg shadow-md ">
    <div class="bg-white mb-5 rounded-lg">
        <!-- User Info with Three-Dot Menu -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <?php if ($studentProfile == 'null') { ?>
                <img src="https://placehold.co/600x400" alt="User Avatar" class="w-8 h-8 rounded-full">
                <?php } else { ?>
                <img src="<?= $studentProfile ?>" alt="User Avatar" class="w-8 h-8 rounded-full">
                <?php } ?>

                <div>
                    <p class="text-gray-800 font-semibold"><?= $studentName ?></p>
                    <!-- Date -->
                    <?php
                    // Récupérer la date stockée dans la base de données
                    $createdAt = $date;

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
                <div class="flex items-center space-x-2">
                    <button class="flex justify-center items-center gap-2 px-2 hover:bg-gray-50 rounded-full p-1">
                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M12 21.35l-1.45-1.32C6.11 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-4.11 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        <span>42</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Image -->
        <?php
        // Assure-toi que `$images` est une liste d'URLs d'images
// Assure-toi également que `$images` n'est pas vide
        
        // Initialiser l'URL de la grande image avec la première image de la liste
        $imageUrl = !empty($images) ? $images[0] : '';

        // Code HTML pour afficher la grande image et les miniatures
        ?>
        <div class="mb-4">
            <!-- Grande image -->
            <div class="mb-3">
                <!-- Afficher la grande image avec l'ID "mainImage" -->
                <img id="mainImage" src="<?= htmlspecialchars($imageUrl) ?>" alt="Post Image"
                    class="w-full h-58 object-cover mb-5 rounded-md">
            </div>
            <!-- Petites images -->
            <div class="flex items-center gap-2 sm:gap-4 md:gap-6">
                <?php foreach ($images as $url) { ?>
                <!-- Bouton pour chaque miniature -->
                <button class="thumbnail-button" onclick="changeImage('<?= htmlspecialchars($url) ?>')">
                    <!-- Afficher chaque miniature -->
                    <img src="<?= htmlspecialchars($url) ?>" alt="Thumbnail"
                        class="thumbnail-image w-full object-cover object-center rounded-lg">
                </button>
                <?php } ?>
            </div>
        </div>

        <!-- Message -->
        <!-- Like and Comment Section -->
        <div class="flex items-center justify-between text-gray-500">
            <div class="flex items-center space-x-2">
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
        <div class="mb-4">
            <p class="text-gray-800">Merci<a href="" class="text-blue-600">Lorem ipsum dolor sit amet consectetur
                    adipisicing elit. Nisi error neque iste, eveniet asperiores modi doloribus quae nostrum nesciunt,
                    eos quis amet aspernatur? Iusto maxime eligendi, reiciendis optio officiis facilis. Reiciendis,
                    ipsum neque id dolor inventore enim nihil sint possimus numquam excepturi optio blanditiis non
                    voluptatum corporis nam ipsam deserunt, amet incidunt iusto ipsa. Quis quia earum cum aliquam
                    officia rerum repudiandae minus, saepe eveniet sed voluptates iure pariatur omnis illum nesciunt
                    adipisci. Itaque, quod cumque necessitatibus incidunt obcaecati provident quas, temporibus
                    voluptates praesentium sed delectus officiis cupiditate quidem. Nihil, quae sed ut culpa possimus
                    corporis consectetur nulla provident in?</a>
                <a href="" class="text-blue-600">#AdventureCat</a>
            </p>
        </div>

        <!-- Commentaire -->
        <form action="" method="post">
            <textarea id="message" rows="2"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300"
                placeholder="Ajoutez un commentaire" oninput="toggleButtonVisibility()"></textarea>
            <button type="submit" name="send" id="commentButton"
                class="bg-indigo-400 hover:bg-indigo-300 text-white p-1 mt-3 rounded-lg"
                style="display: none;">Commenter</button>
        </form>
        <div class="flex w-full p-1 border-b border-gray-300">
            <img src="https://res.cloudinary.com/do2qwucmp/image/upload/v1713868947/ygfrhqhvgb29hbovvyzm.jpg"
                alt="User Avatar" class="w-8 h-8 rounded-full">
            <div class="flex flex-col flex-grow ml-4">
                <div class="flex">
                    <span class="font-semibold text-sm">@Username</span>
                    <span class="ml-auto text-sm">Just now</span>
                </div>
                <p class="mt-1 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                    incididunt ut labore et dolore magna aliqua. <a class="underline" href="#">#hashtag</a></p>
                <div class="flex mt-2">
                    <button class="text-sm font-semibold">Like</button>
                    <button class="ml-2 text-sm font-semibold">Reply</button>
                    <button class="ml-2 text-sm font-semibold">Share</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
//Formulaire button

function toggleButtonVisibility() {
    const textarea = document.getElementById('message');
    const button = document.getElementById('commentButton');

    if (textarea.value.trim() === '') {
        button.style.display = 'none';
    } else {
        button.style.display = 'inline-block';
    }
}
// Cette fonction change l'image principale en fonction de l'URL de l'image miniature cliquée.
function changeImage(imageUrl) {
    // Trouve l'élément image principale par son ID et change sa source
    const mainImage = document.getElementById('mainImage');
    mainImage.src = imageUrl;
}
</script>

<style>
.thumbnail-image {
    width: 100px;

    height: 100px;
    object-fit: cover;
}

.thumbnail-button {
    width: 100px;
    /* Ajustez selon vos besoins */
    height: 100px;
    /* Ajustez selon vos besoins */
}
</style>