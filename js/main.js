function init(){
    welcomeMessage();
    loadCourses();
}

let courseYear = [];

//Test Data
const courses = [
    {"courseName": "IT2023/01", "firstLeader": "Max Mustermann", "secondLeader": "Erika Musterfrau"},
    {"courseName": "IT2023/07", "firstLeader": "Erika Musterfrau", "secondLeader": "Max Mustermann"},
    {"courseName": "IT2024/01", "firstLeader": "Hans Müller", "secondLeader": "Anna Schmidt"},
    {"courseName": "IT2024/07", "firstLeader": "Peter Fischer", "secondLeader": "Laura Weber"},
    {"courseName": "IT2025/01", "firstLeader": "Sophie Wagner", "secondLeader": "Lukas Becker"},
    {"courseName": "IT2025/07", "firstLeader": "Julia Hoffmann", "secondLeader": "Tim Schäfer"},
];

const loginInData = [
    {"lastName": "Lange", "gender": "m"},
    {"lastName": "Fichtner", "gender": "m"},
    {"lastName": "Laufer", "gender": "m"}
];

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

function loadCourses(){    
    let courseOverview = document.getElementById('course_overview');
    let coursesContainer = document.getElementById('courses');
    courseOverview.innerHTML = '';
    
    for(let i = 0; i < courses.length; i++){
        let year = courses[i].courseName.split('/')[0].substring(2);
        if(!courseYear.includes(year)){
            courseYear.push(year);
        }
        courseOverview.innerHTML += getCourse(courses[i], i);
    }
    coursesContainer.value = "";
};

function filterCourses(){
    let coursesContainer = document.getElementById('courses');
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
    } else {
        container.innerHTML = '<p style="padding: 20px;">Kein Kurs ausgewählt</p>';
    }
}



