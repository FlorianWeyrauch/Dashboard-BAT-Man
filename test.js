async function getData(path = "") {
    let response = await fetch(BASE_URL + path + ".json");
    let responseData = await response.json();
    return responseData;
}


let test = await getData("./ajax/get_db_data_courses.php");

console.log(test);