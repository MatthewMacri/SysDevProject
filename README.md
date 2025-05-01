# Project/Inventory Management System

## Overview
Our project focuses on developing a **Project/Inventory Management System** for -----. These companies operate in the **mechanical engineering industry**, specializing in designing and manufacturing driveline components such as gears, shafts, and related equipment for heavy industries like mining, oil and gas, and power generation.

The primary goal is to create a **web application** that helps ----- manage inventory efficiently and monitor processes. 

### Meeting Schedule
- **Tuesdays** (12:00 PM - 2:00 PM) - System Development Class
- **Mondays** (8:30 AM - 11:30 AM) - In-person meeting
- Additional meetings as required

### Tools & Collaboration
- **Virtual Meetings:** Discord (for screen sharing and collaboration)
- **Documentation:** Google Docs
- **Code Repository:** GitHub

---

## Team Organization
### Team Meetings
- **Tuesdays (12:00 - 2:00 PM)** - Theory class of System Development
- **Mondays (8:30 - 11:30 AM)** - Additional in-person meeting
- **Supplementary meetings** scheduled as needed

### Repositories
- **GitHub Repository:** [GitHub Link](#)  
- **Google Drive:** [Drive Link](https://drive.google.com/drive/folders/1IKmMJHQ8GsyfiEsLtdMCoJcwRlNlh5Fj?usp=sharing)  

### Communication Strategy
- **Primary communication:** Discord (Text and Voice Channels)
- **Urgent updates:** SMS messaging
- **Discussion organization:** Separate text channels on Discord (e.g., `#brainstorm` for ideas)
- **Meeting discussions:** Discord voice channels
- **Discord Invite:** [Join Server](https://discord.gg/qdcdxH8paM)

---

## Team Policies
| Policy Number | Description |
|--------------|-------------|
| 1 | Always communicate with respect and professionalism. |
| 2 | Ensure all tasks are completed by agreed deadlines. |
| 3 | Actively participate in team meetings and discussions. |
| 4 | Share progress updates regularly. |
| 5 | Support team members when needed. |
| 6 | Promote inclusivity and a welcoming environment. |

---

## Responsibilities
| Implementation Task | Assigned Member(s) |
|--------------------|------------------|
| **Back-end Development** | Tarek Abou Chahin, Matthew Macri |
| **Front-end Development** | Matthew Veroutis |
| **Database Management** | Kais Rafie |

*Note: Collaboration across domains is encouraged when needed.*

---

## Client Contact
- **Primary Contact:** Matthew Macri
- **Reason:** Established relationship with the client, ensuring consistency and trust.
- **Other members may attend meetings as needed.**

---

## Project Plan
Our **project plan** is structured based on the instructions and deadlines outlined in the course syllabus. Since some project tasks are unclear, we are actively communicating with instructors for clarification. 

### Key Points:
- Tasks assigned based on **skills, efficiency, and preference**.
- Tasks may change based on evolving requirements.
- Workload is balanced among all members to ensure fairness.
- The project plan will be **revised before each deliverable** to optimize workflow.

## How To Install
As the project will be stored and run from a physical server that the company own, it will be compiled for efficiency purposes for enhancing access and saving space.

### Check the Following Before Running the Project

1. Check node existence by using `node -v`
2. Check Node Package Manager using `npm -v`
3. Install all dependencies using `npm install`

#### Run the Project
* **Note** `that you should always use the following command when testing the project is needed`
Finally, use the command `npm run dev` to decompile the project and enjoy working on it!

### -v Not Working
That means the tools are not installed. Install [node.js](https://nodejs.org), download .msi for windows or .pkg for macOS, and try the commands again. if the `npm -v` is not working, that means the node.js is corrupt or incomplete, try installing [node.js](https://nodejs.org) again then try the command.

### other errors
If you encounter this error `npm WARN saveError ENOENT: no such file or directory, open '.../package.json'`, that means the `package.json` does not exist. It should exist, therefore try running `npm init` in the root and press enter for all prompts to keep the defaults or use `npm init -y` to skip the defaults. Your package.json should look like this for **now**:

``` 
{
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "dev": "vite"
    },
    "devDependencies": {
        "@tailwindcss/vite": "^4.0.0",
        "axios": "^1.8.2",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^1.2.0",
        "tailwindcss": "^4.0.0",
        "vite": "^6.2.4"
    }
}
```
---

## Conclusion
This document serves as a **guideline** for our **Project/Inventory Management System**. With clear team roles, structured communication, and a well-defined plan, we aim for successful project completion while maintaining efficiency and teamwork.

### TO DO
* INCLUDE THE NAV BAR IN ALL OF THE VIEWS 
* Creating the CRUDs functions
* Connect views with crud functions
* Transfer all HTML files to PHP 
* Connecting the views together (FULL USER JOURNEY)
* Create the server connection 
* Log in (remember me button on the log in, remembers for a certain amount of time) & Log out  
* 2FA (Google 2FA)
* Set up .env and exclude it in the .gitignore
* Export as PDF and QR code api 
* Authorization and Authentication
* SQL Injection prevention
* Custom Errors 
* Code annotation and unite testing

## Future Implementation
* Alerts in the calendar from gaant and kanban

