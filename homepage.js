
const postButton = document.querySelector('.post-button');
const popupContainer = document.querySelector('.popup-container');
const closePopupButton = document.querySelector('.popup-box .close-button');
const postPopupButton = document.querySelector('.popup-box button:not(.close-button)');


postButton.addEventListener('click', () => {
    popupContainer.classList.remove('hidden');
});


closePopupButton.addEventListener('click', () => {
    popupContainer.classList.add('hidden');
});


postPopupButton.addEventListener('click', () => {

    console.log('Post button clicked');
    popupContainer.classList.add('hidden');
});
