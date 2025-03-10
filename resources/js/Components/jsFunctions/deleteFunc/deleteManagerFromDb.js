export default async function DeleteManagerFromDb(id) {
    try {
        const response = await fetch('/deleteManager', {
            method: 'DELETE',

            data: { id: id },
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
        return 'success'; // Возвращаем данные как массив
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
