function drawPieChart(canvas, data) {
    const ctx = canvas.getContext('2d');
    // x mitte
    const centerX = canvas.width / 2;  
    // y mitte
    const centerY = canvas.height / 2;
    // radius berechnen
    const radius = Math.min(centerX, centerY);
    
    // Addiert alle Werte zusammen um die Gesamtsumme zu erhalten (für Prozentberechnung)
    let total = 0;
    for (let i = 0; i < data.length; i++) {
        total = total + data[i].value;
    }
    
    // Startet bei -90° (12 Uhr Position), weil 0° bei 3 Uhr wäre
    // -Math.PI / 2 = -90° in Radiant
    let currentAngle = -Math.PI / 2;
    
    // Geht durch jedes Datenelement (FIAE, FISI, FIDM)
    data.forEach((item, index) => {
        // Berechnet wie groß der Anteil dieses Segments am Gesamtkreis ist
        // (Wert / Gesamt) * 360° = Winkel für dieses Segment
        // 2 * Math.PI = 360° in Radiant
        const sliceAngle = (item.value / total) * 2 * Math.PI;
        
        // Startet einen neuen Zeichenpfad
        ctx.beginPath();
        
        // Bewegt den "Stift" zur Mitte des Kreises (Startpunkt)
        ctx.moveTo(centerX, centerY);
        
        // Zeichnet einen Kreisbogen von currentAngle bis currentAngle + sliceAngle
        // arc(x, y, radius, startWinkel, endWinkel)
        ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
        
        // Schließt den Pfad zurück zum Mittelpunkt (macht ein "Tortenstück")
        ctx.closePath();
        
        // Setzt die Füllfarbe auf die Farbe aus den Daten
        ctx.fillStyle = item.color;
        
        // Füllt das Segment mit der gewählten Farbe
        ctx.fill();
        
        // Setzt die Randfarbe auf Weiß für Trennung zwischen Segmenten
        ctx.strokeStyle = '#fff';
        
        // Setzt die Randdicke auf 3 Pixel
        ctx.lineWidth = 3;
        
        // Zeichnet den weißen Rand um das Segment
        ctx.stroke();
        
        // Addiert den gerade gezeichneten Winkel zum aktuellen Winkel
        // Dadurch startet das nächste Segment dort, wo dieses aufhört
        currentAngle += sliceAngle;
    });
}

// Funktion zum Erstellen der Legende (Beschriftung unter dem Diagramm)
function createLegend(data) {
    // Holt das HTML-Element mit der ID "legend"
    const legend = document.getElementById('legend');
    
    // Löscht den bisherigen Inhalt (falls vorhanden)
    legend.innerHTML = '';
    
    // Geht durch jedes Datenelement
    data.forEach(item => {
        // Erstellt ein neues div-Element für einen Legendeneintrag
        const legendItem = document.createElement('div');
        
        // Gibt dem div die CSS-Klasse "legend-item"
        legendItem.className = 'legend-item';
        
        // Erstellt ein div für das Farbquadrat
        const colorBox = document.createElement('div');
        
        // Gibt dem Farbquadrat die CSS-Klasse "legend-color"
        colorBox.className = 'legend-color';
        
        // Setzt die Hintergrundfarbe des Quadrats auf die Farbe aus den Daten
        colorBox.style.backgroundColor = item.color;
        
        // Erstellt ein span-Element für den Text
        const label = document.createElement('span');
        
        // Setzt den Text: z.B. "FIAE: 9"
        label.textContent = `${item.label}: ${item.value}`;
        
        // Fügt das Farbquadrat in den Legendeneintrag ein
        legendItem.appendChild(colorBox);
        
        // Fügt den Text in den Legendeneintrag ein
        legendItem.appendChild(label);
        
        // Fügt den kompletten Legendeneintrag in die Legende ein
        legend.appendChild(legendItem);
    });
}

// Array mit Beispieldaten: Label (Name), Wert (Anzahl), Farbe (Hex-Code)
const data = [
    { label: 'FIAE', value: 9, color: '#e2001a' },  // Rot
    { label: 'FISI', value: 7, color: '#333333' },  // Dunkelgrau
    { label: 'FIDM', value: 5, color: '#999999' }   // Hellgrau
];

// Holt das Canvas-Element aus dem HTML
const canvas = document.getElementById('pieChart');

// Ruft die Funktion auf, um das Kreisdiagramm zu zeichnen
drawPieChart(canvas, data);

// Ruft die Funktion auf, um die Legende zu erstellen
createLegend(data);