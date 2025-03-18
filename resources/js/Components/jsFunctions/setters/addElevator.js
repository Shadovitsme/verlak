export default async function addElevator(name, adressId, entrance) {
    try {
        const response = await fetch('/addElevator', {
            method: 'POST',
            body: JSON.stringify({
                name: name,
                adressId: adressId,
                entrance: entrance,
            }),
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
