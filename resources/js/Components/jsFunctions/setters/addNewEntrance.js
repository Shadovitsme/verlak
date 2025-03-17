export default async function addEntrance(id, name) {
    try {
        const response = await fetch('/addEntrance', {
            method: 'POST',
            body: JSON.stringify({
                id: id,
                name: name,
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
