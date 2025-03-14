document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('sos-btn').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    console.log("✅ Latitude récupérée :", latitude);
                    console.log("✅ Longitude récupérée :", longitude);

                    let dataToSend = {
                        action: "send_sos_sms",
                        latitude: latitude,
                        longitude: longitude
                    };

                    console.log("📡 Données envoyées à WordPress :", dataToSend);

                    fetch(wp_ajax_url, {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: new URLSearchParams(dataToSend)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("📨 Réponse serveur :", data);
                        alert("🚨 Alerte envoyée avec succès ! Vos contacts ont été prévenus.");
                    })
                    .catch(error => {
                        console.error("❌ Erreur d'envoi SOS:", error);
                        alert("❌ Une erreur est survenue lors de l'envoi du SOS. Veuillez réessayer.");
                    });
                },
                error => {
                    console.error("❌ Erreur de géolocalisation :", error.message);
                    alert("❌ Impossible de récupérer votre position. Activez la localisation sur votre appareil.");
                }
            );
        } else {
            console.error("❌ La géolocalisation n'est pas supportée par ce navigateur.");
            alert("❌ Votre navigateur ne supporte pas la géolocalisation.");
        }
    });
});
