let currentCourse = getFromSessionStorage('selectedCourse');

function init(){
    loadCurrentStudents();
    renderCourseDiagram(currentCourse);
}

function loadCurrentStudents() {
    let courseHeader = document.getElementById('course_header');
    let courseContainer = document.getElementById('course_student_display');
    let students = [];
    currentCourse.students.forEach(element => {
        students.push(element);
        bubbleSortStudents(students);
    });
    courseHeader.innerHTML = getCourseHeader(currentCourse);
    courseContainer.innerHTML = "";
    students.forEach(element => {
        courseContainer.innerHTML += getStudent(element);
    });
    clearStudentOverview();    
}

function bubbleSortStudents(arr) {
    let n = arr.length;
    for (let i = 0; i < n - 1; i++) {
        for (let j = 0; j < n - i - 1; j++) {
            if (arr[j].lastName > arr[j + 1].lastName) {
                let temp = arr[j];
                arr[j] = arr[j + 1];
                arr[j + 1] = temp;
            }
        }
    }
    return arr;
}

function filterStudent() {
    let nameInput = document.getElementById("name_input");
    let professionSelect = document.getElementById("profession_selection");
    let statusSelect = document.getElementById("status_selection");
    let courseContainer = document.getElementById('course_student_display');
    let currentCourse = getFromSessionStorage('selectedCourse');
    
    let nameFilter = nameInput.value.toLowerCase();
    let selectedProfession = professionSelect.value;
    let selectedStatus = statusSelect.value;
    
    courseContainer.innerHTML = '';
    
    currentCourse.students.forEach(element => {
        let fullName = (element.firstName + ' ' + element.lastName).toLowerCase();
        let matchesName = nameFilter === "" || fullName.includes(nameFilter);
        let matchesProfession = selectedProfession === "" || element.profession.toLowerCase() === selectedProfession.toLowerCase();
        let matchesStatus = selectedStatus === "" || element.status.toLowerCase() === selectedStatus.toLowerCase();
        
        if (matchesName && matchesProfession && matchesStatus) {
            courseContainer.innerHTML += getStudent(element);
        }
    });
}

function clearStudentOverview() {
    let name = document.getElementById("name_input");
    let profession = document.getElementById("profession_selection");
    let status = document.getElementById("status_selection");
    name.value = "";
    profession.value = "";
    status.value = "";
}

function renderSingleStudentOverview(data) {
    let overlayContainer = document.getElementById("overlay");
    overlayContainer.classList.remove("d-none");
    switch (data.profession) {
        case "FIAE":
            data.profession = "Fachinformatiker/in Anwendungsentwicklung";
            break;
        case "FISI":
            data.profession = "Fachinformatiker/in Systemintegration";
            break;
        case "FIDM":
            data.profession = "Kauffrau/-mann für Digitalisierungsmanagement";
            break;
        default:
            break;
    }

    switch (data.status) {
        case "green":
            data.status = "Praktikumsvertrag";
            break;
        case "yellow":
            data.status = "Hohe Bewerberaktivität";
            break;
        case "red":
            data.status = "Niedrige Bewerberaktivität";
            break;
        default:
            break;
    }

    overlayContainer.innerHTML = getSingleStudentOverview(data);
}



function closeSingleStudentOverview() {
    let overlayContainer = document.getElementById("overlay");
    overlayContainer.classList.add("d-none");
    overlayContainer.innerHTML = "";
}

overlay.addEventListener("click", (event) => {
  if (event.target === overlay) {
    closeSingleStudentOverview();
  }
});
