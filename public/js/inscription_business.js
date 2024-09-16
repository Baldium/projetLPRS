document.querySelector('form').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        event.preventDefault();
    }
});
companyNameInput.addEventListener('input', function() {
    const query = companyNameInput.value.toLowerCase();
    companyNameSuggestions.innerHTML = '';
    if (query) {
        const suggestions = companyNames.filter(name => name.toLowerCase().includes(query));
        suggestions.forEach(name => {
            const suggestionDiv = document.createElement('div');
            suggestionDiv.textContent = name;
            suggestionDiv.addEventListener('click', () => {
                companyNameInput.value = name;
                companyNameSuggestions.innerHTML = '';
            });
            companyNameSuggestions.appendChild(suggestionDiv);
        });
    }
});

const companyAddressInput = document.getElementById('company-address');
const companyAddressSuggestions = document.getElementById('company-address-suggestions');
const companyAddresses = ['123 Main St', '456 Elm St', '789 Maple Ave'];

companyAddressInput.addEventListener('input', function() {
    const query = companyAddressInput.value.toLowerCase();
    companyAddressSuggestions.innerHTML = '';
    if (query) {
        const suggestions = companyAddresses.filter(address => address.toLowerCase().includes(query));
        suggestions.forEach(address => {
            const suggestionDiv = document.createElement('div');
            suggestionDiv.textContent = address;
            suggestionDiv.addEventListener('click', () => {
                companyAddressInput.value = address;
                companyAddressSuggestions.innerHTML = '';
            });
            companyAddressSuggestions.appendChild(suggestionDiv);
        });
    }
});

const emailInput = document.getElementById('email');
emailInput.addEventListener('input', function() {
    const email = emailInput.value.toLowerCase();
    const disposableDomains = ['yopmail.com', 'tempmail.com', 'mailinator.com']; 
    const isDisposable = disposableDomains.some(domain => email.endsWith('@' + domain));
    emailInput.setCustomValidity(isDisposable ? 'Les adresses email jetables ne sont pas acceptées.' : '');
});