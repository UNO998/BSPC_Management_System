# BSPC_Management_System
Relational database application system for Bahamas Sports Physio Center

## Tool && FrameWork
- MySQL
- PHP
- [XAMPP](https://www.apachefriends.org/index.html)
- HTML
- visual Paradiagm

## Project Description
### Abstract
- Implement a system to organize the operational management for a hospital.
- Users are able to create/delete/edit/view information through browser according to their own
authorization.

### Registration
When a physio patient arrives at the physio center, the receptionist checks to see if the patient is already registered with the center. If the patient is already registered then his/her Personal Health Number is retrieved; otherwise, the receptionist will register the new patient. The physio center only treats physio patients who are at least 18 years old.

### Appointment
Each physio patient must be referred by a physio trainer and must present a prescription number to the receptionist.
A physio patient may be referred to different physio doctors at different times in different centers by the trainer. When a patient visits the center at the appointed time he/she will be assigned to a specific Physical therapist/Doctor referred by a trainer.
A receptionist as an admin should be able to make appointments on behalf of a patient if requested.
A patient can also make an appointment for a specific date and time eight weeks in advance limited to one appointment for any given day.
### Therapists/Doctors details
The center only employs Physio Therapists who have at least 2 years of prior experience and Doctors with at least 6 years. The center records doctors/therapist availability for next 60 days.

### Prescription, Treatment and diagnosis
Each prescription must be recorded by the BSPC system. Each prescription will list a diagnosis such as a “strained muscle therapy” or “muscle pull therapy” and the description of the doctor note (max. text limit of 100 words). The system must also record which therap ists treated the physio patient on a specific visit to the center, treatment received and equipment used.
A patient can receive more than one type of treatment and use more than one piece of equipment at any given visit.
Sample equipment “stationary bicycle “,” treadmill”,” weights”.
Sample treatment “heat”,” ice”,” electrical stimulation”,” ultrasound massage”.

### Access rights
Two kinds of users can access the system: At Administrator (receptionist/nurse/doctor) level and user (patient) level.
- Administrator
  - Receptionist
  Receptionist should be able to retrieve staff information (list of doctors, therapist and nurses available on a given     date), update appointment for patient, view patient past records and update staff details.
  - Nurse/Doctor
  Can update records, insert, alter and view patients updated record.
- Patient
  - Patient
Can only view and make an appointment.
If the patient is referred by a trainer, for a specific treatment with specific therapist, system should not allow patient to make an appointment with other doctor for the same treat me nt.
### Payment
Patients can pay by cash, cheque, credit or debit cards. Payment method and details of payments must be recorded. The card details should be sent daily to the card processing agency to verify the payments including the amount and date.

### UserInterface
Use the MySQL DBMS to develop a miniature database application system for the BSPC system. The BSBC system should provide its users with a good graphical user interface that is simple and dedicated for novice users. The system should be able to create/delete/edit/view whether for members or users of all kinds needed for the operations of the physio center.

## Database Design
#### Database Schema
- Registration
- Appointment
- Therapists
- Doctors
- Prescription
- Treatment
- Diagnosis
- Payment

#### Access rights
- Administrator (receptionist/nurse/doctor)
- User(patient)

#### Database E/R diagram
![](./Database_E:R.png)
