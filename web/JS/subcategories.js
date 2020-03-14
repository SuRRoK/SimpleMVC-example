const categoryInput = document.querySelector('select#category');

categoryInput.addEventListener('change', evt => {
    let catId = evt.target.value;
    if (catId == 0) {
        noCategory();
    } else {
        generateSubcat(filterSubcat(catId));
    }
});
const filterSubcat = function (id) {
    return subcategories.filter(item => item.categoryId === id);
};

const noCategory = function () {
    const subcategoryInput = document.querySelector('select#subcategory');
    subcategoryInput.value = 0;
    subcategoryInput.disabled = 'disabled';
};

const generateSubcat = function (array) {
    if (typeof(articleSubcategory) === undefined) {
        let articleSubcategoryExists = false
    } else {
        let articleSubcategoryExists = true
    }
    const subcategoryInput = document.querySelector('select#subcategory');
    subcategoryInput.disabled = false;
    subcategoryInput.innerHTML = '';
    const optionNoneFr = document.querySelector('#optionNone').content.querySelector('option');
    const optionGroupFr = document.querySelector('#optionGroup').content.querySelector('optgroup');
    const optionFr = document.querySelector('#option').content.querySelector('option');
    let optionsHTML = document.createDocumentFragment();
    // элемент селекта "Без подкатегории"
    let optionHTML = optionNoneFr.cloneNode(true);
    optionsHTML.appendChild(optionHTML);
    // элемент селекта Группа
    let optionGroupHTML = optionGroupFr.cloneNode(true);
    optionGroupHTML.label = subcategories[0]['categoryName'];
    // формируем элементы селекта под группой
    array.forEach((item) => {
        optionHTML = optionFr.cloneNode(true);
        optionHTML.value = item['id'];
        optionHTML.textContent = item['name'];
        if(typeof(articleSubcategory) !== 'undefined' && articleSubcategory == item['id']) {
            optionHTML.selected = true;
        }
        optionGroupHTML.appendChild(optionHTML);
    });

    optionsHTML.appendChild(optionGroupHTML);
    subcategoryInput.appendChild(optionsHTML);
};

let catID = categoryInput.value;

if (catID == 0) {
    noCategory();
} else {
    generateSubcat(filterSubcat(catID));
}