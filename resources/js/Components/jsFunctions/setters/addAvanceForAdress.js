export default async function addAvanceForAdress(
    id = false,
    workerAdressId,
    comment,
    avanceValue,
    date,
) {
    try {
        const response = await fetch('/addAvanceForAdress', {
            method: 'POST',
            body: JSON.stringify({
                id: id,
                workerAdressId: workerAdressId,
                comment: comment,
                avanceValue: avanceValue,
                date: date,
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

        return data;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
