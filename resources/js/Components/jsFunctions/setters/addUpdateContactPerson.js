export default async function addUpdateContactPerson(
    name,
    work,
    phone,
    adress,
    contactGroupId,
    idPerson,
) {
    try {
        const response = await fetch('/updateContactPerson', {
            method: 'POST',
            body: JSON.stringify({
                name: name,
                work: work,
                phone: phone,
                adress: adress,
                contactGroupId: contactGroupId,
                idPerson: idPerson,
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
