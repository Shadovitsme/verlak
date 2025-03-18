export default async function updateElevatorData(
    adressId,
    elevatorName,
    descriptionName,
    descriptionValue,
    commentValue,
    entrance,
) {
    try {
        const response = await fetch('/updateElevatorData', {
            method: 'POST',
            body: JSON.stringify({
                adressId: adressId,
                elevatorName: elevatorName,
                descriptionName: descriptionName,
                descriptionValue: descriptionValue,
                commentValue: commentValue,
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
