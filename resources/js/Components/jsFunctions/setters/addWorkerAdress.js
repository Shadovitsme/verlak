export default async function addWorkerAdress(
    workerId,
    name,
    fullPrice = 0,
    avanceValue,
    comment,
    date,
) {
    try {
        const response = await fetch('/addWorkerAdress', {
            method: 'POST',
            body: JSON.stringify({
                workerId: workerId,
                name: name,
                fullPrice: fullPrice,
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
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error;
    }
}
