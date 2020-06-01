# Vote_Online_Website
<br>
<br>
<br>
<b>SECURITY MEASURES</b><br><br>

1. postAuthKey: Authentication key to validate that a request is made from our app or website<br>
2. smsAuthKey: Authentication key to validate that our app or website wants to use the paid sms service<br>
<br>
<br>
3. Booth OTP: To validate that no one can log in to booth outside the designated office<br>
4. Booth automatic logout on focus change or window close: So that laptop cannot be used to take logged in booth outside office [IN PROGRESS]<br>
<br>
5. Booth automatic logout after certain time: Prevents attacker from using booth for a long period of time[IN PROGRESS]<br>
<br>
6. Every database update or create operation checks for logged in booth: Prevents attackers from crashing database<br>
<br>
7. App election id is matched with booth entered election id: Prevents booth staff to choose different election<br>
<br>
8. Only one chance to vote per voter: Prevents attackers to repetedly try to vote using an aadhaar number<br>
<br>
9. Image verification at booth to verify the appearance of the voter<br>
10. Cross OTP verification via registered mobile number/biometric scan of voter: Prevents imposters to vote in the voter's stead. Prevents the booth staff to approve fake people.<br>
11. Incorporated approval, voted status and NOTA vote with voter verification: Prevents attacker from faking an approval as this needs logged in booth and voter's registered mobile number/biometrics<br>
12. Only one active approval per booth: Prevents booth to approve another voter unless the previous voter in line has finished voting. Ensures that only the approval of the head of the line is removed after a vote is cast.<br>
13. Approval is expired after a few minutes: Prevents attacker from blocking booth line<br>
<br>
14. sms request is sent from logged in booth: Prevents attackers from repeatedly sending sms to exhaust the sms limits.<br>
<br>
<br>
15. Only constituency name, phase election Id and boothId are stored in approval: Helps maintain anonimity<br>
16. Voter has to enter booth OTP to re validate his presence in logged in booth: Prevents attackers from getting hold of the voting panel as the show panel and booth OTP verification are incorporated in same file.<br>
17. Head of line is cleared after a certain time automatically: Prevents attackers from blocking a booth<br> 
<br>
18. Random encryption key for each vote is sent from server: Prevents decryption of every vote with a single encryption key<br> 
<br>
19. Number of people voted and number of votes are matched: To maintain integrity and then a NOTA vote is removed to store the original vote. Head of the line is also cleared.<br>
<br>
<br>
20. Randomly encrypted votes are stored in the database: Prevents the ECI staff from viewing the exact votes.<br>
<br>
21. Customized random number generator: Prevents attacker from guessing the key number or OTP even with knowledge of pseudo random algorithm
<br>
22. Approval deletion check in current call before adding vote: Prevents attacker to sneak in a vote at the same time with the voter
<br>
23. Seperate database to store the vote bank: Prevents ECI staff to view the encrypted votes
<br>
24. Votes are stored in cluster: Prevents attacker to find out the order of votes
<br>
25. Server ip check: Prevents attacker from using postman/curl to make fake requests
<br>
26. Protection against SQL injection
<br>
27. Protection against Buffer overload
<br>
28. Otps in the database are encrypted: Database team member cannot login to a booth or admin account
<br>
29. Sms is only sent to valid voters who have not voted
<br>
30. At most 4 sms can be sent to a voter from a booth in an election: Prevents booth staff from depleting the sms limit
<br>
31. Alpha numeric OTP: Makes guessing nearly impossible
<br>
32. OTP to be entered in voting panel will be constant for a voter: Outsiders cannot change the OTP by making false attempts(When the approval is removed, the OTP will be changed)
<br>
<br>
<br>
<br>
