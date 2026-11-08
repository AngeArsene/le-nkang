<x-layouts.main>
    <svg width="0" height="0" style="position:absolute" aria-hidden="true">
        <defs>
            <symbol id="i-home" viewBox="0 0 24 24">
                <path d="m3 10 9-7 9 7v10h-6v-6H9v6H3z" />
            </symbol>
            <symbol id="i-search" viewBox="0 0 24 24">
                <circle cx="10.8" cy="10.8" r="6.5" />
                <path d="m16 16 4.2 4.2" />
            </symbol>
            <symbol id="i-spark" viewBox="0 0 24 24">
                <path d="m12 2 1.7 7 6.3 3-6.3 3-1.7 7-1.7-7L4 12l6.3-3z" />
            </symbol>
            <symbol id="i-heart" viewBox="0 0 24 24">
                <path d="M20.4 8.7c0 4.5-8.4 10-8.4 10s-8.4-5.5-8.4-10A4.2 4.2 0 0 1 12 6.1a4.2 4.2 0 0 1 8.4 2.6Z" />
            </symbol>
            <symbol id="i-msg" viewBox="0 0 24 24">
                <path d="M4 5.5h16v12H9l-5 3z" />
            </symbol>
            <symbol id="i-user" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="3.5" />
                <path d="M4.5 20c.7-4 3.2-6 7.5-6s6.8 2 7.5 6z" />
            </symbol>
            <symbol id="i-share" viewBox="0 0 24 24">
                <circle cx="18" cy="5" r="2.5" />
                <circle cx="6" cy="12" r="2.5" />
                <circle cx="18" cy="19" r="2.5" />
                <path d="m8.3 10.8 7.4-4.5m-7.4 7 7.4 4.5" />
            </symbol>
            <symbol id="i-phone" viewBox="0 0 24 24">
                <path
                    d="M7 3h3l1.5 4-2 1.8a15 15 0 0 0 5.7 5.7l1.8-2 4 1.5v3c0 1.1-.9 2-2 2C11 19 5 13 5 5c0-1.1.9-2 2-2Z" />
            </symbol>
            <symbol id="i-wa" viewBox="0 0 24 24">
                <path d="M20 11.5a8 8 0 0 1-11.7 7.1L4 20l1.4-4A8 8 0 1 1 20 11.5Z" />
                <path d="M9 9.3c.3 2.2 2 3.9 4.2 4.2" />
            </symbol>
            <symbol id="i-flag" viewBox="0 0 24 24">
                <path d="M5 21V4m0 1h13l-2.5 4L18 13H5" />
            </symbol>
            <symbol id="i-eye" viewBox="0 0 24 24">
                <path d="M2.5 12s3.3-6 9.5-6 9.5 6 9.5 6-3.3 6-9.5 6-9.5-6-9.5-6Z" />
                <circle cx="12" cy="12" r="2.5" />
            </symbol>
            <symbol id="i-check" viewBox="0 0 24 24">
                <path d="m5 12 4.3 4.3L19 6.8" />
            </symbol>
            <symbol id="i-plus" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14" />
            </symbol>
            <symbol id="i-x" viewBox="0 0 24 24">
                <path d="M6 6l12 12M18 6 6 18" />
            </symbol>
            <symbol id="i-left" viewBox="0 0 24 24">
                <path d="m15 6-6 6 6 6" />
            </symbol>
            <symbol id="i-right" viewBox="0 0 24 24">
                <path d="m9 6 6 6-6 6" />
            </symbol>
            <symbol id="i-arrow" viewBox="0 0 24 24">
                <path d="m9.5 5 7 7-7 7M16 12H3" />
            </symbol>
            <symbol id="i-clock" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" />
                <path d="M12 7v5l3 2" />
            </symbol>
            <symbol id="i-globe" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" />
                <path d="M3 12h18M12 3c3 3 3 15 0 18M12 3c-3 3-3 15 0 18" />
            </symbol>
            <symbol id="i-pin" viewBox="0 0 24 24">
                <path d="M19 10c0 5-7 11-7 11S5 15 5 10a7 7 0 1 1 14 0Z" />
                <circle cx="12" cy="10" r="2" />
            </symbol>
            <symbol id="i-shield" viewBox="0 0 24 24">
                <path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z" />
                <path d="m9 12 2 2 4-4" />
            </symbol>
        </defs>
    </svg>
    <div class="app">
        <aside class="side" aria-label="Navigation principale">
            <a class="logo" href="#main" aria-label="Le Nkang, accueil">
                <span class="mark">
                    <svg viewBox="0 0 32 32" aria-hidden="true">
                        <path d="M7 25V7h4v7l8-7h6l-9 8 10 10h-6l-7-7-2 2v5z" />
                    </svg>
                </span>
                <span>Le <b>Nkang</b></span>
            </a>
            <div class="side-body">
                <p class="side-label">Général</p>

                <nav class="nav" aria-label="Explorer">
                    <a href="#main" class="on" aria-current="page">
                        <svg class="ic">
                            <use href="#i-home" />
                        </svg>
                        Accueil
                    </a>
                    <a href="#autres">
                        <svg class="ic">
                            <use href="#i-search" />
                        </svg>
                        Explorer
                    </a>
                    <a href="#autres">
                        <svg class="ic">
                            <use href="#i-spark" />
                        </svg>
                        Nouveautés
                    </a>
                    <a href="#autres">
                        <svg class="ic">
                            <use href="#i-heart" />
                        </svg>
                        Favoris
                    </a>
                    <a href="#contact">
                        <svg class="ic">
                            <use href="#i-msg" />
                        </svg>
                        Messages
                    </a>
                </nav>

                <p class="side-label">Villes</p>

                <nav class="nav cities" aria-label="Villes">
                    <a href="#autres" class="on">Douala<span>128</span></a>
                    <a href="#autres">Yaoundé<span>96</span></a>
                    <a href="#autres">Bafoussam<span>18</span></a>
                    <a href="#autres">Kribi<span>12</span></a>
                </nav>
            </div>

            <div class="side-foot">
                <a class="btn pink" href="#">
                    <svg class="ic">
                        <use href="#i-plus" />
                    </svg>
                    <span class="t-long">Publier mon annonce</span>
                    <span class="t-short">Publier</span>
                </a>
                <a class="nav-mini" href="#">
                    <svg class="ic">
                        <use href="#i-globe" />
                    </svg>
                    Français
                </a>
                <a class="nav-mini" href="#">
                    <svg class="ic">
                        <use href="#i-user" />
                    </svg>
                    Connexion
                </a>
            </div>
        </aside>

        <main class="main" id="main">
            <label class="search">
                <span class="search-btn">
                    <svg class="ic">
                        <use href="#i-search" />
                    </svg>
                </span>
                <span class="pill">
                    <input type="search" placeholder="Rechercher une annonce, un quartier…" aria-label="Rechercher">
                    <span class="search-in">
                        Dans :
                        <button type="button" class="on">Annonces</button>
                        <button type="button">Quartiers</button>
                        <button type="button">Villes</button>
                    </span>
                </span>
            </label>
            <div class="topline">
                <a class="back" href="#autres" aria-label="Retour aux annonces">
                    <svg class="ic">
                        <use href="#i-left" />
                    </svg>
                </a>
                <p class="crumbs"><a href="#">Accueil</a> / <a href="#autres">Douala</a> / Bonapriso</p>
                <span class="inprog"><i></i>En ligne</span>
            </div>

            <header class="hero">
                <div class="avatar">
                    <div class="ph">
                        <img data-img="1" alt="Portrait illustré de Skinny Délicieuse">
                    </div>
                    <span class="sticker" title="Profil vérifié">
                        <svg class="ic">
                            <use href="#i-check" />
                        </svg>
                        <span class="sr">Profil vérifié</span>
                    </span>
                </div>

                <div>
                    <h1>{{ $announcement->title }}</h1>

                    <div class="hero-sub">
                        <span class="tier">OR</span>
                        <span class="muted">Annonce indépendante · Bonapriso, Douala</span>
                    </div>

                    <ul class="meta">
                        <li>
                            <svg class="ic">
                                <use href="#i-eye" />
                            </svg>
                            {{ $announcement->views_count }} vues
                        </li>
                        <li>
                            <svg class="ic">
                                <use href="#i-heart" />
                            </svg>
                            <span data-likes>128</span>
                            favoris
                        </li>
                        <li>Publiée {{ $announcement->created_at->diffForHumans() }}</li>
                        <li><a href="#avis">★ <span data-avg>4,7</span> · <span data-total>36</span> avis</a></li>
                    </ul>
                </div>
            </header>

            <section class="card gallery" aria-label="Galerie photo">
                <div class="g-main">
                    <img id="gMain" alt="Portrait illustré, ambiance nocturne" width="800" height="1000">
                    <span class="g-count" id="gCount" aria-live="polite">1 / 5</span>
                    <button class="g-arrow l" id="gPrev" aria-label="Photo précédente">
                        <svg class="ic">
                            <use href="#i-left" />
                        </svg>
                    </button>
                    <button class="g-arrow r" id="gNext" aria-label="Photo suivante">
                        <svg class="ic">
                            <use href="#i-right" />
                        </svg>
                    </button>
                </div>

                <div class="g-tiles" id="gTiles"></div>
            </section>

            <section class="card beige about" aria-labelledby="t-about">
                <h2 id="t-about">À propos</h2>

                <div class="clamp" id="about">
                    <p @style(['display: inline'])>{{ mb_substr($announcement->description, 0, 150) }}</p>
                    @if (Str::length($announcement->description) > 150)
                        <span id="dots">...</span>
                    @endif

                    <p id="lessText" @style(['display: none'])>{{ mb_substr($announcement->description, 150) }}</p>
                </div>
                @if (Str::length($announcement->description) > 150)
                    <button class="btn dark sm" id="more" aria-expanded="false" aria-controls="about">
                        Lire la suite
                    </button>
                @endif
            </section>

            <div class="bento">
                <section class="card yellow rates" aria-labelledby="t-tarifs">
                    <h2 id="t-tarifs">Tarifs</h2>

                    <p class="from">À partir de</p>

                    <p class="big">15 000 <small>FCFA</small></p>

                    <ul class="bars">
                        <li>
                            <div><span>1 heure</span><b>15 000</b></div>
                            <i style="--w:60%"></i>
                        </li>
                        <li>
                            <div><span>2 heures</span><b>25 000</b></div>
                            <i style="--w:100%"></i>
                        </li>
                        <li>
                            <div><span>La nuit</span><b>Sur demande</b></div>
                            <i style="--w:0%"></i>
                        </li>
                    </ul>
                </section>

                <section class="card pink views" aria-labelledby="t-views">
                    <h2 id="t-views">Vues</h2>

                    <p class="num">1 284 <small>au total</small></p>
                    <svg
                        class="chart"
                        viewBox="0 0 300 96"
                        role="img"
                        aria-label="Aperçu de l’évolution des vues sur 7 jours">
                        <path
                            d="M2 66C22 54 34 74 54 62S88 34 108 44s34 22 54 4 34-34 54-26 34 28 52 16 22-10 28-8"
                            fill="none"
                            stroke="#141414"
                            stroke-width="2"
                            stroke-linecap="round" />
                        <line x1="216" y1="22" x2="216" y2="96" stroke="#141414" stroke-dasharray="4 4" />
                        <circle cx="216" cy="22" r="5" fill="#141414" />
                    </svg>
                    <div class="days">
                        <span>Lun</span>
                        <span>Mar</span>
                        <span>Mer</span>
                        <span>Jeu</span>
                        <span>Ven</span>
                        <span>Sam</span>
                        <span>Dim</span>
                    </div>
                </section>
            </div>

            <div class="bento two">
                <section class="card info" aria-labelledby="t-info">
                    <div class="info-h">
                        <h2 id="t-info">Infos pratiques</h2>
                        <span>Vérifiée</span>
                    </div>

                    <div class="info-b">
                        <dl>
                            <div>
                                <dt>Quartier</dt>
                                <dd>Bonapriso, Douala</dd>
                            </div>

                            <div>
                                <dt>Horaires</dt>
                                <dd>Tous les jours, 10 h – 22 h</dd>
                            </div>
                        </dl>

                        <div class="minis">
                            <div class="mini">
                                <h3>
                                    <svg class="ic">
                                        <use href="#i-globe" />
                                    </svg>
                                    Langues
                                </h3>

                                <p><span>Français</span><span>English</span></p>
                            </div>

                            <div class="mini">
                                <h3>
                                    <svg class="ic">
                                        <use href="#i-spark" />
                                    </svg>
                                    Services
                                </h3>

                                <p><span>Rencontre</span><span>Sortie</span><span>Sur demande</span></p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="card blue safety" aria-labelledby="t-safe">
                    <h2 id="t-safe">Restez prudent·e</h2>

                    <ul>
                        <li>
                            <svg class="ic">
                                <use href="#i-shield" />
                            </svg>
                            Ne versez jamais d’argent à l’avance.
                        </li>
                        <li>
                            <svg class="ic">
                                <use href="#i-pin" />
                            </svg>
                            Choisissez un lieu de rencontre où vous vous sentez en sécurité.
                        </li>
                        <li>
                            <svg class="ic">
                                <use href="#i-user" />
                            </svg>
                            Prévenez une personne de confiance de vos déplacements.
                        </li>
                    </ul>
                </section>
            </div>

            <section class="reviews" id="avis" aria-labelledby="t-rev">
                <div class="rev-head">
                    <h2 id="t-rev">Avis</h2>

                    <div class="rev-tools">
                        <div class="pager" id="revPager">
                            <button type="button" id="revPrev" aria-label="Avis précédents">
                                <svg class="ic">
                                    <use href="#i-left" />
                                </svg>
                            </button>
                            <span id="revPage" aria-live="polite">1 / 1</span>
                            <button type="button" id="revNext" aria-label="Avis suivants">
                                <svg class="ic">
                                    <use href="#i-right" />
                                </svg>
                            </button>
                        </div>
                        <button class="btn dark sm" id="revBtn" aria-expanded="false" aria-controls="revForm">
                            Laisser un avis
                        </button>
                    </div>
                </div>

                <form class="rev-form" id="revForm" hidden>
                    <div class="rev-form-head">
                        <h3>Laisser un avis</h3>
                        <button type="button" class="rev-close" id="revClose" aria-label="Fermer le formulaire">
                            <svg class="ic">
                                <use href="#i-x" />
                            </svg>
                        </button>
                    </div>

                    <div class="row2">
                        <label>
                            Prénom (facultatif)
                            <input name="author" maxlength="30" autocomplete="given-name">
                        </label>
                        <label>
                            Note
                            <select name="rating">
                                <option value="5">5 – Excellent</option>
                                <option value="4">4 – Très bien</option>
                                <option value="3">3 – Correct</option>
                                <option value="2">2 – Décevant</option>
                                <option value="1">1 – Mauvais</option>
                            </select>
                        </label>
                    </div>
                    <label>
                        Votre avis
                        <textarea
                            name="text"
                            rows="3"
                            minlength="10"
                            maxlength="400"
                            required
                            placeholder="Communication, ponctualité, respect…"></textarea>
                    </label>
                    <div class="rev-actions">
                        <button class="btn dark sm" type="submit">Publier mon avis</button>
                        <button class="btn line sm" type="button" id="revCancel">Annuler</button>
                    </div>
                </form>

                <div class="rev-body">
                    <div class="card green rev-sum" id="revSum"></div>

                    <div class="rev-list" id="revList"></div>
                </div>
            </section>

            <section class="others" id="autres" aria-labelledby="t-others">
                <div class="others-head">
                    <div>
                        <h2 id="t-others">D’autres annonces à Douala</h2>

                        <p id="count" class="muted"></p>
                    </div>
                </div>

                <div class="chips" id="chips" role="group" aria-label="Filtrer par quartier"></div>

                <div class="grid" id="grid"></div>
            </section>
        </main>

        <aside class="right" id="contact">
            <div class="tools">
                <button aria-label="Profil">
                    <svg class="ic">
                        <use href="#i-user" />
                    </svg>
                </button>
                <button aria-label="Discussion rapide" id="toolChat">
                    <svg class="ic">
                        <use href="#i-msg" />
                    </svg>
                </button>
                <button aria-label="Favoris">
                    <svg class="ic">
                        <use href="#i-heart" />
                    </svg>
                </button>
            </div>

            <section class="contact" aria-labelledby="t-contact">
                <div class="c-head">
                    <h2 id="t-contact">Contacter</h2>
                    <span class="status"><i></i>Disponible</span>
                </div>

                <div>
                    <p class="muted sm">À partir de</p>

                    <p class="price">15 000 <small>FCFA</small></p>
                </div>
                <a class="btn dark lg" href="https://wa.me/237690123456" target="_blank" rel="noopener noreferrer">
                    <svg class="ic">
                        <use href="#i-wa" />
                    </svg>
                    Écrire sur WhatsApp
                </a>
                <a class="btn line" href="tel:+237690123456">
                    <svg class="ic">
                        <use href="#i-phone" />
                    </svg>
                    Appeler
                </a>
                <div class="acts">
                    <button id="share">
                        <span>
                            <svg class="ic">
                                <use href="#i-share" />
                            </svg>
                        </span>
                        <em>Partager</em>
                    </button>
                    <button id="fav" aria-pressed="false">
                        <span>
                            <svg class="ic">
                                <use href="#i-heart" />
                            </svg>
                        </span>
                        <em>Favori · <b data-likes>128</b></em>
                    </button>
                    <button id="report">
                        <span>
                            <svg class="ic">
                                <use href="#i-flag" />
                            </svg>
                        </span>
                        <em>Signaler</em>
                    </button>
                </div>

                <p class="fine">Le Nkang ne traite aucun paiement. Prenez le temps de vérifier les informations.</p>
            </section>

            <section class="avail" aria-labelledby="t-avail">
                <div class="r-head">
                    <div>
                        <h2 id="t-avail">Disponibilités</h2>

                        <p class="muted sm">Horaires indicatifs</p>
                    </div>
                    <span class="select">Cette semaine</span>
                </div>

                <div class="week" id="week" aria-label="Jours de la semaine"></div>

                <div class="slot">
                    <span class="dot pink">
                        <svg class="ic">
                            <use href="#i-clock" />
                        </svg>
                    </span>
                    <div>
                        <b>Disponible aujourd’hui</b>
                        <p>10 h – 22 h · convenez du lieu et de l’heure par message</p>
                    </div>
                </div>
            </section>
        </aside>

        <footer class="foot">
            <span>© 2026 Le Nkang</span>
            <span>Réservé aux adultes (18+)</span>
            <a href="#t-safe">Conseils de sécurité</a>
            <a href="#">Confidentialité</a>
            <a href="#">Conditions</a>
        </footer>
    </div>
    <button class="fav-launch" id="favFloat" aria-pressed="false" aria-label="Ajouter aux favoris">
        <svg class="ic">
            <use href="#i-heart" />
        </svg>
    </button>
    <button class="chat-launch" id="chatOpen" aria-label="Ouvrir la discussion rapide" aria-expanded="false">
        <svg class="ic">
            <use href="#i-msg" />
        </svg>
    </button>
    <section class="chat" id="chat" hidden aria-label="Discussion rapide">
        <button class="chat-x" id="chatX" aria-label="Fermer">
            <svg class="ic">
                <use href="#i-x" />
            </svg>
        </button>
        <h3>Discussion rapide</h3>

        <div class="bubbles">
            <p>Bonjour, vous souhaitez contacter Skinny ?</p>

            <p>Elle répond dès que possible, en journée comme en soirée.</p>

            <p class="me">Quelles sont vos disponibilités ?</p>
        </div>
        <a
            class="btn pink"
            href="https://wa.me/237690123456?text=Bonjour%2C%20j%E2%80%99ai%20vu%20votre%20annonce%20sur%20Le%20Nkang."
            target="_blank"
            rel="noopener noreferrer">
            <svg class="ic">
                <use href="#i-wa" />
            </svg>
            Écrire sur WhatsApp
        </a>
    </section>

    <div class="mbar" aria-label="Contacter l’annonceuse">
        <a class="btn dark" href="https://wa.me/237690123456" target="_blank" rel="noopener noreferrer">
            <svg class="ic">
                <use href="#i-wa" />
            </svg>
            WhatsApp
        </a>
        <a class="btn line" href="tel:+237690123456">
            <svg class="ic">
                <use href="#i-phone" />
            </svg>
            Appeler
        </a>
    </div>

    <div class="toast" id="toast" role="status" aria-live="polite"></div>
</x-layouts.main>
