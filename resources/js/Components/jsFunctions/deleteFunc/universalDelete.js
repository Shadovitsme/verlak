export default async function universalDelete(id, api) {
    try {
        const response = await fetch(api, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
                id: id,
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return 'success'; // Возвращаем данные как массив
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
