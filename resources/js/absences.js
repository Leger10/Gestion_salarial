// public/js/absences.js

function toggleAbsenceStatus(employerId, isActive) {
    // Récupérer l'élément badge pour cet employeur
    let badge = document.getElementById('absence-badge-' + employerId);

    if (badge) {
        // Alterner la couleur du badge (grisé ou actif)
        if (isActive) {
            badge.classList.remove('text-muted');  // Enlever 'text-muted' (grisé)
            badge.classList.add('bg-danger');      // Ajouter 'bg-danger' (actif)
        } else {
            badge.classList.remove('bg-danger');  // Enlever 'bg-danger' (actif)
            badge.classList.add('text-muted');    // Ajouter 'text-muted' (grisé)
        }
    }

    // Appeler la fonction pour mettre à jour le total des heures d'absence
    updateTotalAbsence();
}

function updateTotalAbsence() {
    let totalAbsence = 0;

    // Calculer le total des heures d'absence pour tous les employés (ceux avec la classe 'bg-danger')
    document.querySelectorAll('.badge.bg-danger').forEach(function (badge) {
        totalAbsence += parseInt(badge.textContent.replace(' h', ''), 10);
    });

    // Mettre à jour le badge avec le total des heures d'absence
    document.getElementById('total-absence-badge').textContent = totalAbsence + ' h';
}

// Fonction JavaScript pour gérer le clic du bouton pour alterner le statut de l'absence
document.querySelectorAll('.btn-toggle-absence').forEach(button => {
    button.addEventListener('click', function () {
        let employerId = this.dataset.employerId;
        
        // Envoyer la requête pour alterner le statut de l'absence
        fetch(`/toggle-absence/${employerId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ employer_id: employerId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour le total des heures d'absence et le statut du badge
                updateTotalAbsence();
            }
        });
    });
});
