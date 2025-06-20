function toggleFullMenu(menuType) {
    const fullMenuSection = document.getElementById('fullWeekMenu');
    if (fullMenuSection.style.display === 'none') {
        fullMenuSection.style.display = 'block';
    } else {
        fullMenuSection.style.display = 'none';
    }
}
