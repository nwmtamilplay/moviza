document.querySelector("#getimdb").addEventListener("click", async () => {
    const apiKey = '7a02b9aa'; // Your OMDb API key
    const movieId = document.querySelector('#inputImdb').value; // Replace with the IMDb ID you want to search
    if (movieId.trim() != '') {
        await fetch(`https://www.omdbapi.com/?i=${movieId}&apikey=${apiKey}`)
            .then(response => response.json())
            .then(data => {
                if (data.Response === 'True') {
                    console.log(data); // Movie data
                } else {
                    console.log('Movie not found!');
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }
})


