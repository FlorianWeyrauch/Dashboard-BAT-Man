function init(){
    welcomeMessage();
    loadCourses();
}

// alle vorhanden Jahre aus json abspeichern
let courseYear = [];

//testdaten login
const loginInData = [
    {"lastName": "Lange", "gender": "m"},
    {"lastName": "Fichtner", "gender": "m"},
    {"lastName": "Laufer", "gender": "m"}
];


//Nachname aus dem Login holen und als begrüßung anzeigen lassen -> Sven
function welcomeMessage(){
    let container = document.getElementById('welcome_message');
    if(loginInData[0].gender === "m"){
        container.innerHTML = `Willkommen Herr ${loginInData[0].lastName}`;
    } else if(loginInData[0].gender === "f"){
        container.innerHTML = `Willkommen Frau ${loginInData[0].lastName}`;
    } else {
        container.innerHTML = `Willkommen ${loginInData[0].lastName}`;
    }
}

//Wichtig!!!
// Schleife anpassen je nachdem wie die kurse in das json geladen werden
function loadCourses(){    
    let courseOverview = document.getElementById('course_overview');
    courseOverview.innerHTML = '';
    
    for(let i = courses.length - 1; i >= 0; i--){
        let year = courses[i].courseName.split('/')[0].substring(2);
        if(!courseYear.includes(year)){
            courseYear.push(year);
        }
        courseOverview.innerHTML += getCourse(courses[i], i);
    }
    loadCourseYear();
};

//läd alle vorhanden Kursjahre in das dropdown rein
function loadCourseYear(){
    let coursesContainer = document.getElementById('courses_selection');
    courseYear.sort().reverse();
    coursesContainer.innerHTML = "";
    coursesContainer.innerHTML = getYearOptionPlaceholder();
    courseYear.forEach((element) =>{
        coursesContainer.innerHTML += getYearOption(element);
    });
    coursesContainer.value = "";
}


//Filter Funktion für die Kursübersicht
// Eingabe = IT2024/07 vergleichen mit arr
function filterCourses(){
    let coursesContainer = document.getElementById('courses_selection');
    let courseOverview = document.getElementById('course_overview');
    let selectedYear = coursesContainer.value;
    if(selectedYear == ""){
        // loadCourses();
        return;
    }
    courseOverview.innerHTML = '';
    for(let i = 0; i < courses.length; i++){
        let year = courses[i].courseName.split('/')[0].substring(2);
        if(year == selectedYear){
            courseOverview.innerHTML += getCourse(courses[i], i);
        };
    }
}

// übergabe des indexes des angeklickten Kurses
// abspeichern im Session Storage
// weiterleiten auf den angeklickten Kurs
function showCurrentCourse(index){
    let selectedCourse = courses[index];
    saveToSessionStorage('selectedCourse', selectedCourse);
    window.location.href = "./student-overview.php";
}

// Funktion für student-overview.php
function loadStudentOverview(){
    let selectedCourse = getFromSessionStorage('selectedCourse');
    let container = document.getElementById('student_overview');
    
    if(!container) return; 
    
    if(selectedCourse) {
        container.innerHTML = `
            <div style="padding: 20px;">
                <h2>${selectedCourse.courseName}</h2>
                <p>Kursleiter: ${selectedCourse.firstLeader} / ${selectedCourse.secondLeader}</p>
            </div>
        `;
    }
}

function updateStatusColor(selectElement) {
    selectElement.classList.remove('color-red', 'color-yellow', 'color-green');
    let value = selectElement.value;
    if(value === 'red') {
        selectElement.classList.add('color-red');
    } else if(value === 'yellow') {
        selectElement.classList.add('color-yellow');
    } else if(value === 'green') {
        selectElement.classList.add('color-green');
    }
}



