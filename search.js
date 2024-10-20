document.addEventListener('DOMContentLoaded', function() {
    // Fetch JSON data for NGOs
    fetch('data.json')
        .then(response => response.json())
        .then(data => {
            const ngoContainer = document.getElementById('ngo-container');
            const searchInput = document.getElementById('searchInput');

            // Display all NGOs initially
            let ngoHTML = '';
            data.sections.education.forEach(ngo => ngoHTML += createNGOCard(ngo));
            data.sections.healthcare.forEach(ngo => ngoHTML += createNGOCard(ngo));
            data.sections.environment.forEach(ngo => ngoHTML += createNGOCard(ngo));
            ngoContainer.innerHTML = ngoHTML;

            // Filter NGOs based on search input
            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                let filteredHTML = '';

                data.sections.education.forEach(ngo => {
                    if (ngo.name.toLowerCase().includes(searchTerm) || ngo.description.toLowerCase().includes(searchTerm)) {
                        filteredHTML += createNGOCard(ngo);
                    }
                });
                data.sections.healthcare.forEach(ngo => {
                    if (ngo.name.toLowerCase().includes(searchTerm) || ngo.description.toLowerCase().includes(searchTerm)) {
                        filteredHTML += createNGOCard(ngo);
                    }
                });
                data.sections.environment.forEach(ngo => {
                    if (ngo.name.toLowerCase().includes(searchTerm) || ngo.description.toLowerCase().includes(searchTerm)) {
                        filteredHTML += createNGOCard(ngo);
                    }
                });

                ngoContainer.innerHTML = filteredHTML || '<p>No results found.</p>';
            });

            // Function to create NGO card
            function createNGOCard(ngo) {
                return `
                    <div class="col-md-4">
                        <div class="card">
                            <img src="${ngo.image}" class="card-img-top" alt="${ngo.name}">
                            <div class="card-body">
                                <h5 class="card-title">${ngo.name}</h5>
                                <p class="card-text">${ngo.description}</p>
                                <a href="${ngo.website}" target="_blank" class="btn btn-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => console.error('Error loading JSON data:', error));
});
