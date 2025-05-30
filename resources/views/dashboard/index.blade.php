
@extends('master')

@section('content')

<main id="main" class="main">
    <style>
        #calendar {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            min-height: 400px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.08);
            padding: 20px 10px;
        }

        .fc-event {
            border: none !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.08);
            font-weight: 500;
            transition: transform 0.1s, box-shadow 0.1s;
            cursor: pointer;
        }
        .fc-event:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 16px rgba(44, 62, 80, 0.15);
            z-index: 10;
        }
        .fc-day-today {
            background: #e3f2fd !important;
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s cubic-bezier(.4,0,.2,1);
            transform: translateY(-30px) scale(0.98);
        }
        .modal.fade.show .modal-dialog {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            background: linear-gradient(90deg, #3640f5 0%,rgb(89, 139, 247) 100%);
            color: #fff;
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
        }
        .modal-title strong {
            color: #ffe082;
        }
        .modal.fade .modal-dialog {
            transition: transform 0.3s cubic-bezier(.4,0,.2,1), opacity 0.3s;
            transform: translateY(-30px) scale(0.98);
            opacity: 0;
        }
        .modal.fade.show .modal-dialog {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .fc-day-sat, .fc-day-sun {
            background: #f8fafc !important;
        }

        /* Taille de police par défaut pour l'agenda */
    .fc {
        font-size: 1rem;
    }

    /* Adapter la taille de police sur tablette */
    @media (max-width: 992px) {
        .fc {
            font-size: 0.95rem;
        }
        .fc-toolbar-title {
            font-size: 1.1rem;
        }
    }

    /* Adapter la taille de police sur mobile */
    @media (max-width: 768px) {
        .fc {
            font-size: 0.85rem;
        }
        .fc-toolbar-title {
            font-size: 1rem;
        }
        .fc .fc-daygrid-day-frame {
            min-height: 60px;
        }
    }

    /* Adapter la taille de police sur très petit écran */
    @media (max-width: 480px) {
        .fc {
            font-size: 0.75rem;
        }
        .fc-toolbar-title {
            font-size: 0.50rem;
        }
    }


        .disponible {
            background-color: #e8f5e9;
            border-left: 4px solid #2e7d32; /* vert */
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }
        .indisponible {
            background-color: #ffebee;
            border-left: 4px solid #c62828; /* rouge */
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }
        .validee {
            background-color: #e3f2fd;
            border-left: 4px solid #3640f5; /* bleu */
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }
        .attente {
            background-color: #fffde7;
            border-left: 4px solid #ffb300; /* orange */
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        .autre {
        background-color: #f3f6f9;           /* gris très clair */
        border-left: 4px solid #90a4ae;      /* bleu-gris */
        padding: 10px;
        margin-bottom: 5px;
        border-radius: 4px;
    }
    </style>

    <div class="pagetitle">
        <h1>Tableau de bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>
    </div>

    @if(Auth::check() && Auth::user()->hasRole('administrateur'))
         @include('partials.admin-dashboard')
    @elseif(Auth::check() && Auth::user()->hasRole('gestionnaire'))
        @include('partials.gestionnaire-dashboard')
    @elseif(Auth::check() && Auth::user()->hasRole('utilisateur'))
        @include('partials.utilisateur-dashboard')
    @else
    <section>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> Agenda des réservations </h5>
                        <div id="calendar"></div>
                        <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex flex-wrap justify-content-center gap-3 align-items-center">
                                        <span class="d-flex align-items-center">
                                            <span style="display:inline-block;width:18px;height:18px;background:#e8f5e9;border-left:4px solid #2e7d32;border-radius:4px;margin-right:6px;"></span>
                                            Terminé
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <span style="display:inline-block;width:18px;height:18px;background:#ffebee;border-left:4px solid #c62828;border-radius:4px;margin-right:6px;"></span>
                                            Annulé
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <span style="display:inline-block;width:18px;height:18px;background:#e3f2fd;border-left:4px solid #3640f5;border-radius:4px;margin-right:6px;"></span>
                                            Validé
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <span style="display:inline-block;width:18px;height:18px;background:#fffde7;border-left:4px solid #ffb300;border-radius:4px;margin-right:6px;"></span>
                                            En attente
                                        </span>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- Modal pour afficher les détails de la réservation -->
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reservationModalLabel">
                        <i class="bi bi-calendar-event"></i>
                        Détails réservation pour : <strong><span id="modalSalle"></span></strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p></p>
                    <p><strong>Direction :</strong> <span id="modalDirection"></span></p>
                    <p><strong>Motif :</strong> <span id="modalMotif"></span></p>
                    <p><strong>Date de début :</strong> <span id="modalStartTime"></span></p>
                    <p><strong>Date de fin :</strong> <span id="modalEndTime"></span></p>
                    <p><strong>Statut :</strong> <span id="modalStatus"></span></p>
                    <p><strong>Priorité :</strong> <span id="modalPriority"></span></p>
                </div>
                <div class="modal-footer">
                    <a href="#" id="modalEditLink" class="btn btn-primary">Modifier</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setInterval(function() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, 'text/html');
                let newContentEl = doc.querySelector('.table-responsive');
                let currentContentEl = document.querySelector('.table-responsive');
                if (newContentEl && currentContentEl) {
                    currentContentEl.innerHTML = newContentEl.innerHTML;
                }
            });
    }, 30000);
});

document.addEventListener('DOMContentLoaded', function () {
    // Définir userRole et userId côté JS depuis Blade
const userRole = @json(Auth::check() ? Auth::user()->getRoleNames()->first() : null);
const userId = @json(Auth::check() ? Auth::user()->id : null);


    let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
      //  initialView: 'dayGridMonth',
        initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth', // Vue liste sur mobile
        height: 'auto',
        contentHeight: 'auto',
        aspectRatio: 1.5,
        firstDay: 1,
       // themeSystem: 'bootstrap',
        windowResize: function(view) {
            if(window.innerWidth < 768) {
                calendar.changeView('listWeek');
            } else {
                calendar.changeView('dayGridMonth');
            }
        },
        events: @json($reservationsForCalendar),
        locale: 'fr',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: 'Aujourd\'hui',
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour'
        },

        eventDidMount: function(info) {
            let event = info.event;
            let element = info.el;

            // Ajouter une classe CSS en fonction du statut de l'événement
            if (event.extendedProps.status === 'terminé') {
                element.classList.add('disponible');
            } else if (event.extendedProps.status === 'annulé') {
                element.classList.add('indisponible');
            } else if (event.extendedProps.status === 'validé') {
                element.classList.add('validee');
            } else if (event.extendedProps.status === 'en attente') {
                element.classList.add('attente');
            } else {
                element.classList.add('autre');
            }
        },

        eventClick: function(info) {
            let event = info.event;

            // Remplir les champs du modal avec les données de l'événement
            document.getElementById('modalSalle').textContent = event.extendedProps.salle || 'Non spécifié';
            document.getElementById('modalDirection').textContent = event.extendedProps.direction || 'Non spécifié';
            document.getElementById('modalMotif').textContent = event.extendedProps.motif || 'Non spécifié';
            document.getElementById('modalStartTime').textContent = event.start.toLocaleString();
            document.getElementById('modalEndTime').textContent = event.end ? event.end.toLocaleString() : 'Non spécifié';
            document.getElementById('modalStatus').textContent = event.extendedProps.status || 'Non spécifié';
            document.getElementById('modalPriority').textContent = event.extendedProps.priority || 'Non spécifié';

            // Ajouter un lien pour modifier la réservation
            let editLink = document.getElementById('modalEditLink');
            editLink.href = `/reservations/${event.id}/edit`;

            // Désactiver le bouton "Modifier" si nécessaire
        //    let userId = event.extendedProps.user_id || null;
            let creatorId = event.extendedProps.creator_id || null;
            let status = event.extendedProps.status ? event.extendedProps.status.toLowerCase() : '';

            if (['terminé', 'annulé', 'archivé'].includes(status) ||
                (!['administrateur', 'gestionnaire'].includes(userRole) && userId !== creatorId)) {
                editLink.classList.add('disabled'); // Ajouter la classe "disabled"
                editLink.setAttribute('aria-disabled', 'true'); // Accessibilité
                editLink.style.pointerEvents = 'none'; // Empêcher les clics
            } else {
                editLink.classList.remove('disabled'); // Supprimer la classe "disabled"
                editLink.removeAttribute('aria-disabled'); // Supprimer l'attribut d'accessibilité
                editLink.style.pointerEvents = 'auto'; // Réactiver les clics
            }

            // Afficher le modal
            let reservationModalEl = document.getElementById('reservationModal');
            let reservationModal = new bootstrap.Modal(reservationModalEl);
            reservationModal.show();

            // Nettoyer les anciens écouteurs pour éviter les doublons
            reservationModalEl.onclick = null;
            reservationModalEl.addEventListener('hide.bs.modal', function () {
                document.activeElement.blur();
            }, { once: true });

            // Fermer le modal lorsque l'utilisateur clique en dehors de celui-ci
            reservationModalEl.onclick = function(event) {
                if (event.target === reservationModalEl) {
                    reservationModal.hide();
                }
            };
                    //});

        },

        dayCellDidMount: function(info) {
            const events = info.view.calendar.getEvents().filter(event =>
                event.startStr.startsWith(info.date.toISOString().slice(0, 10))
            );
            if (events.length > 0) {
                let badge = document.createElement('span');
                badge.className = 'badge bg-primary ms-1';
                badge.style.fontSize = '0.7em';
                badge.textContent = events.length;
                info.el.querySelector('.fc-daygrid-day-number')?.appendChild(badge);
            }
        },
        dateClick: function(info) {
            // Rediriger vers la page de création de réservation
            window.location.href = '/reservations/create?date=' + info.dateStr;
        },


    });
    calendar.render();

 });

</script>

@endsection
