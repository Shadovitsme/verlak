export default async function universalDelete(id, api, where = null) {
    try {
        const response = await fetch(api, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
            body: JSON.stringify({
                id: id,
                where: where,
            }),
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return 'success';
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
