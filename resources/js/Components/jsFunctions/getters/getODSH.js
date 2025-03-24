export default async function getODSH(adressId, entrance) {
    try {
        const response = await fetch('/getODSH', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                adressId: adressId,
                entrance: entrance,
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        return data;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
