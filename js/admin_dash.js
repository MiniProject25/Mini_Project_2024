function showStatistics() {
    document.getElementById('statistics-content').style.display = 'block';
    document.getElementById('db-content').style.display = 'none';
    document.getElementById('statistics-tab').classList.add('active');
    document.getElementById('db-tab').classList.remove('active');
}

function showDB() {
    document.getElementById('statistics-content').style.display = 'none';
    document.getElementById('db-content').style.display = 'block';
    document.getElementById('db-tab').classList.add('active');
    document.getElementById('statistics-tab').classList.remove('active');
}

// console.log("hello");