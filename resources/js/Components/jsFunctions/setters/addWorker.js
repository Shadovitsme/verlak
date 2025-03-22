export default async function addUpdateWorker(name, town, id) {
    id == undefined ? (id = false) : id;
    try {
        const response = await fetch('/addWorker', {
            method: 'POST',
            body: JSON.stringify({
                name: name,
                town: town,
                id: id,
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
        const data = await response.json();

        return data; // Возвращаем данные как массив
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
