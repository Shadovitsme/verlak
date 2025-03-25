export default async function setOdshTable(objectArray, adressId, entrance) {
    try {
        const response = await fetch('/setOdshTable', {
            method: 'POST',
            body: JSON.stringify({
                objectArray: objectArray,
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
