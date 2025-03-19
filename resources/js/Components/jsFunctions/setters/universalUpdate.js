export default async function universalUpdate(id, name, value, comment, api) {
    try {
        const response = await fetch(api, {
            method: 'POST',
            body: JSON.stringify({
                id: id,
                name: name,
                value: value,
                comment: comment,
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
