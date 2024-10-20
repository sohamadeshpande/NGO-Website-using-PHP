// Fetch testimonials from JSON file
fetch('testimonials.json')
  .then(response => response.json())
  .then(data => {
    const testimonialContainer = document.getElementById('testimonial-container');
    
    // Generate HTML for each testimonial
    data.forEach(testimonial => {
      const testimonialHTML = `
        <div class="col-md-4">
          <div class="testimonial">
            <p>${testimonial.testimonial}</p>
            <h5>${testimonial.name}</h5>
            <span>${testimonial.designation}</span>
          </div>
        </div>
      `;
      testimonialContainer.insertAdjacentHTML('beforeend', testimonialHTML);
    });
  })
  .catch(error => console.error('Error fetching testimonials:', error));