⭐ Recruitment System – FYP Project
A Complete User + HR Hiring Platform with Real-Time Evaluation
<p align="center"> <img src="https://github.com/Platane/snk/raw/output/github-contribution-grid-snake.svg" alt="snake animation" /> </p>
✨ 📌 Project Overview

This Final Year Project (FYP) is a full-stack recruitment management system built with Laravel & Vue.js.
It features two separate portals:

🔵 1. User Portal (Candidate Side)

Candidate Registration & Login

MCQ-Based Tests (Stage-1 & Stage-2)

Real-Time Test Evaluation

Clean Exam Interface

Automatic Data Sync to HR Portal

🟠 2. HR Portal (Company Side)

Candidate Dashboard

View User Test Scores (MCQ Stages)

Accept / Pending / Reject Actions

Gmail SMTP Email Notifications

Popup Confirmation Alerts

Real-Time User Portal Sync

Multi-DB Architecture (User DB + HR DB + Company DB)

🏗️ Project Architecture (3D Style Diagram)
           🟦 USER PORTAL (Laravel + Vue)
 ---------------------------------------------------
 | Candidate Register/Login                        |
 | MCQ Tests (Stage 1 & 2)                         |
 | Frontend: Vue.js                                |
 | DB: user_portal_db                              |
 ---------------------------------------------------
             ||   Real-Time Data Sync (API)
             ||
             \/
           🟧 HR PORTAL (Admin Panel)
 ---------------------------------------------------
 | Candidate Management                             |
 | Scores Overview                                  |
 | Accept / Pending / Reject                        |
 | SMTP Email Alerts                                |
 | DB: hr_portal_db                                 |
 ---------------------------------------------------
                  ||
                  ||
                  \/
           🟩 SHARED COMPANY DB

🚀 Technologies Used
Frontend

Vue.js

Tailwind CSS

Axios

SweetAlert for Popup Confirmation

Backend

Laravel (PHP)

REST API for Sync

Multiple Database Connections

Database

MySQL

Multi-DB Configuration

Test Scores + Candidate Info

Other

Gmail SMTP

Real-Time Sync API

Laravel Eloquent ORM

🎯 Key Features
⭐ User Portal (Candidates)

Create Account

Attempt MCQ Tests

Stage-Based Flow (Stage 1 → Stage 2 → Interview)

Automated Result Generation

Neat UI / UX for Tests

⭐ HR Portal (Recruiters)

Candidate List + Filters

Candidate Score Dashboard

Accept / Reject / Pending

Email Notification Trigger

Real-Time SQA & Networking Candidate Tables

Multi-DB Live Fetching

⭐ Advanced Features

Secure API Sync

3-Database Integration

Vue.js Dynamic Components

Test Results Charts (optional future upgrade)
