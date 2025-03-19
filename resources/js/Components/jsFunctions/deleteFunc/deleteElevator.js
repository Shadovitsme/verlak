export default async function deleteElevator(name, adressId, entrance) {
    try {
        const response = await fetch('/deleteElevator', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content'),
            },
            body: JSON.stringify({
                name: name,
                adressId: adressId,
                entrance: entrance,
            }),
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
