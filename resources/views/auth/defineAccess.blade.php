<style>
/* Styles généraux */
body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Carrousel */
.styled-carousel {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    overflow: hidden;
}

.swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Conteneur du formulaire */
.container_form {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Formulaire de création de compte */
.single {
    background: rgba(0, 99, 207, .08);
    padding: 10px 25px;
    border-radius: 5px;
    margin: 0 25px 32px 0;
    width: -moz-fit-content;
    width: fit-content;
    color: #0063cf !important;
}

.singup_login {
    color: rgb(176, 59, 20);
    text-transform: uppercase;
    letter-spacing: 2px;
    display: block;
    font-weight: bold;
    font-size: x-large;
    margin-top: 1.5em;
}

.card_login {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 45%;
    width: 25%;
    flex-direction: column;
    gap: 35px;
    border-radius: 15px;
    background: #c8cbc6bc;
    box-shadow: 16px 16px 32px #c8c8c8, -16px -16px 32px #fefefe;
    border-radius: 8px;
    text-align: center;
}

.inputBox_login, .inputBox1_login {
    position: relative;
    width: 75%;
}

.inputBox_login input, .inputBox1_login input {
    width: 100%;
    padding: 10px;
    outline: none;
    border: none;
    color: #000;
    font-size: 1em;
    background: transparent;
    border-left: 2px solid #000;
    border-bottom: 2px solid #000;
    transition: 0.1s;
    border-bottom-left-radius: 8px;
}

.inputBox_login span, .inputBox1_login span {
    margin-top: 5px;
    position: absolute;
    left: 0;
    transform: translateY(-4px);
    margin-left: 10px;
    padding: 10px;
    pointer-events: none;
    font-size: 12px;
    color: #000;
    text-transform: uppercase;
    transition: 0.5s;
    letter-spacing: 3px;
    border-radius: 8px;
}

.inputBox_login input:valid~span, .inputBox_login input:not(:placeholder-shown) ~ span {
    transform: translateX(113px) translateY(-15px);
    font-size: 0.8em;
    padding: 5px 10px;
    background: green;
    letter-spacing: 0.2em;
    color: #fff;
    border: 2px;
}

.inputBox1_login input:valid~span, .inputBox1_login input:not(:placeholder-shown) ~ span {
    transform: translateX(156px) translateY(-15px);
    font-size: 0.8em;
    padding: 5px 10px;
    background: green;
    letter-spacing: 0.2em;
    color: #fff;
    border: 2px;
}

.inputBox_login input:valid, .inputBox_login input:focus, .inputBox1_login input:valid, .inputBox1_login input:focus {
    border: 2px solid #000;
    border-radius: 8px;
}

.enter {
    height: 45px;
    width: 100px;
    border-radius: 7px;
    border: 2px solid #000;
    cursor: pointer;
    background-color: transparent;
    transition: 0.5s;
    text-transform: uppercase;
    font-size: 10px;
    letter-spacing: 2px;
    margin-bottom: 3em;
}

.enter:hover {
    background-color: rgb(0, 0, 0);
    color: white;
}

/* Style pour le formulaire de vérification */
.form-center {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.form-center label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

.form-center input {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.form-center button {
    background-color: #0063cf;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

.form-center button:hover {
    background-color: #004a99;
}

/* Media Queries */
@media (max-width: 1024px) {
    .card_login {
        width: 50%; /* Réduit la largeur du formulaire pour les tablettes */
    }

    .inputBox_login input, .inputBox1_login input {
        font-size: 0.9em; /* Réduit la taille des champs de texte */
    }

    .enter {
        width: 120px; /* Agrandit le bouton pour le rendre plus facile à cliquer sur tablette */
    }
}

@media (max-width: 768px) {
    .card_login {
        width: 60%; /* Réduit encore la largeur du formulaire pour les écrans plus petits */
    }

    .inputBox_login input, .inputBox1_login input {
        font-size: 0.85em; /* Réduit la taille de la police pour les petits écrans */
    }

    .enter {
        width: 150px; /* Ajuste la largeur du bouton pour les petits écrans */
        font-size: 12px; /* Agrandit un peu la taille du texte du bouton */
    }

    /* Ajuste la taille de l'image dans le carrousel */
    .swiper-slide img {
        object-fit: cover;
        height: auto;
    }
}

@media (max-width: 480px) {
    /* Formulaire de connexion */
    .card_login {
        width: 80%; /* Prend plus de place sur les très petits écrans */
    }

    .inputBox_login input, .inputBox1_login input {
        font-size: 0.8em; /* Réduit encore la taille des champs de texte */
    }

    .enter {
        width: 100%; /* Le bouton prend toute la largeur pour plus de visibilité */
        font-size: 14px; /* Taille de texte plus grande */
    }

    /* Image du carrousel */
    .swiper-slide img {
        height: 100px; /* Réduit la taille de l'image pour les petits écrans */
    }

    /* Textes et titres */
    .singup_login {
        font-size: 1.2em; /* Ajuste la taille du texte du titre */
    }
    
    /* Ajustements pour le formulaire de vérification */
    .form-center {
        padding: 15px;
        margin: 15px;
    }
}
</style>
<head>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
    <!-- Bootstrap CSS pour le modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<!-- Carrousel -->
<div class="styled-carousel swiper-container">
    <div class="swiper-wrapper">
        @forelse ($carousels ?? [] as $carousel)
            <div class="swiper-slide">
                <img src="{{ asset('assets/images/imgdefault.jpg') }}" alt="Carousel Image">
            </div>
        @empty
            <div class="swiper-slide">
                <img src="{{ asset('assets/images/armoirie.png') }}" alt="No carousel images available">
            </div>
        @endforelse
    </div>

    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true,
    });
</script>

<!-- Modal Bootstrap -->
<div class="modal fade" id="codeSentModal" tabindex="-1" role="dialog" aria-labelledby="codeSentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="codeSentModalLabel">Code de Vérification Envoyé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        Un email contenant un <strong>code de vérification</strong> a été envoyé à <span class="text-primary">{{ $email }}</span>.  
        <br>Veuillez coller ce code dans le champ prévu et définir votre mot de passe.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Compris</button>
      </div>
    </div>
  </div>
</div>

<div class="container_form">
    <div class="card_login">
        <span class="singup_login">Vérification</span>
        <div class="container">
            <h2><b>Créer votre Compte</b></h2>
            <p>Votre Adresse email <span style="color: #0063cf">: {{ $email }}</span></p>
            
            <!-- Formulaire pour définir un mot de passe -->
            <!-- Tout le code HTML/CSS précédent reste inchangé jusqu'au formulaire -->

<form action="{{ route('account.verify') }}" method="POST" class="form-center">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="inputBox_login">
        <input type="text" name="verification_code" id="verification_code" 
               required="required" placeholder=" " value="{{ old('verification_code') }}">
        <span>Code de vérification</span>
    </div>
    
    <div class="inputBox_login">
        <input type="password" name="password" id="password" 
               required="required" placeholder=" ">
        <span>Nouveau mot de passe</span>
    </div>
    
    <div class="inputBox_login">
        <input type="password" name="password_confirmation" id="password_confirmation" 
               required="required" placeholder=" ">
        <span>Confirmer le mot de passe</span>
    </div>
    
    <button type="submit" class="enter">Valider</button>
</form>

<!-- Le reste du code HTML reste inchangé -->
        </div>
    </div>
</div>

<!-- Bootstrap JS pour le modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Afficher automatiquement le modal au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('codeSentModal'));
        myModal.show();
    });
</script>