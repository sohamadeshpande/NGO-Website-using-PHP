document.addEventListener('DOMContentLoaded', function() {
    // Fetch JSON data for NGOs
    fetch('data.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const ngoContainer = document.getElementById('ngo-container');
            const searchInput = document.getElementById('searchInput');
            // Fetch testimonials from JSON file


            // Function to create an NGO card
            function createNGOCard(ngo) {
                return `
                    <div class="col-md-4 mb-4">
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

            // Function to display NGOs based on filtered search
            function displayNGOs(ngos) {
                let ngoHTML = '';
                ngos.forEach(ngo => ngoHTML += createNGOCard(ngo));
                ngoContainer.innerHTML = ngoHTML || '<p>No results found.</p>';
            }

            // Combine all NGO sections into a single array
            const allNGOs = [
                ...data.sections.education,
                ...data.sections.healthcare,
                ...data.sections.environment,
                ...data.sections.social_welfare
            ];

            // Display all NGOs initially
            displayNGOs(allNGOs);

            // Filter NGOs based on search input
            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                const filteredNGOs = allNGOs.filter(ngo => 
                    ngo.name.toLowerCase().includes(searchTerm) || 
                    ngo.description.toLowerCase().includes(searchTerm)
                );
                displayNGOs(filteredNGOs);
            });
        })
        .catch(error => {
            console.error('Error loading JSON data:', error);
            document.getElementById('ngo-container').innerHTML = '<p>Error loading data.</p>';
        });
});

