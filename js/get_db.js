// send ajax request to get_token.php
async function loadCoursesFromDB() {
    try {
        const response = await $.ajax({
            url: "./ajax/get_db_data_courses.php",
            type: "POST",
            dataType: "json",
            data: {
                prod: false //false == testdaten laden, true == echte DB Verbindung nutzen
            }
        });
        saveToSessionStorage('courses', response);
        return response;
    } catch (error) {
        console.error('AJAX error:', error);
        return null;
    }
}