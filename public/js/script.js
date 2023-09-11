// open step 1 on 'options' btn, close it
const optionsBtn = document.querySelector('#options');
const closeBtn = document.querySelector('#close-btn');
const form = document.querySelector('#form');
const overlay = document.querySelector('#overlay');

optionsBtn.addEventListener('click', () => {
    form.classList.remove('hidden');
    overlay.classList.remove('hidden');
});

closeBtn.addEventListener('click', () => {
    form.classList.add('hidden');
    overlay.classList.add('hidden');
});

overlay.addEventListener('click', (event) => {
    // Vérifie si la cible du clic est l'overlay lui-même et non le formulaire
    if (event.target === overlay) {
        form.classList.add('hidden');
        overlay.classList.add('hidden');
    }
});
