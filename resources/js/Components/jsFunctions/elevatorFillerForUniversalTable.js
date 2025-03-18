import elevatorDefaultArray from './elevatorDefaultArray';

export default function elevatorFillerForUniversalTable(elevatorData) {
    let besideArray = [];
    elevatorArrNames.forEach((element) => {
        besideArray.push([element, elevatorData.entrance, '-']);
    });
    return besideArray;
}
const elevatorArrNames = elevatorDefaultArray;
