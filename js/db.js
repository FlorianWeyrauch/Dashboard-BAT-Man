async function loadData() {
    try {
        const response = await fetch(".php");
        const data = await response.json();
        console.log("Empfangene Daten:", data);
        return data;
    } catch (error) {
        console.error("Fehler:", error);
    }
}
