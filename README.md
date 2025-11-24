🚀 Recruitment System – Multi-Stage Candidate Evaluation Platform


✨ 📌 Project Overview

This project is a full-stack Recruitment Management System developed using Laravel and Vue.js, designed to automate and streamline an end-to-end hiring process.
It includes two fully functional portals — a User Portal for candidates and an HR Portal for recruiters — connected through secure APIs and a multi-database architecture.

The system supports a three-stage evaluation process, automated scoring, real-time data syncing, and HR decision-making with email notifications.

It features two separate portals:

<br>
🔵 1. User Portal (Candidate Side)
<br>

   * Candidate Registration & Login

   * MCQ-Based Tests (Stage-1 & Stage-2)

   * Real-Time Test Evaluation

   * Clean Exam Interface

   * Automatic Data Sync to HR Portal
<br>
🟠 2. HR Portal (Company Side)
<br>

   * Candidate Dashboard

   * View User Test Scores (MCQ Stages)

   * Accept / Pending / Reject Actions

   * Gmail SMTP Email Notifications

   * Popup Confirmation Alerts

   * Real-Time User Portal Sync

   * Multi-DB Architecture (User DB + HR DB + Company DB)

<br>
🏗️ System Architecture (3D Styled Overview)

</br>
  
 🟦 USER PORTAL (Laravel + Vue)
 ---------------------------------------------------
 | Stage 1 - Basic MCQS                            |
 | Stage 2 - Image-Base MCQS                       |
 | Stage 3 - Voice Over Voice Analysis             |
 | Candidate Login/Register                        |
 | DB: user_portal_db                              |
 ---------------------------------------------------
             ||        Real-Time Sync (API)
             ||
             \/
 🟧 HR PORTAL (Admin Panel)
 ---------------------------------------------------
 | Candidate Management                             |
 | View Stage 1, 2, 3 Scores                        |
 | Accept / Pending / Reject                        |
 | SMTP Email Alerts                                |
 | DB: hr_portal_db                                 |
 ---------------------------------------------------
                  ||
                  ||
                  \/
 🟩 SHARED COMPANY DATABASE

<br>
🚀 Technologies Used
<br>

<br>
Frontend
<br>

  * Vue.js

  * Tailwind CSS

  * Axios

  * SweetAlert for Popup Confirmation

<br>
Backend
<br>

  * Laravel (PHP)

  * REST API for Sync

  * Multiple Database Connections

<br>
Database
<br>

  * MySQL

  * Multi-DB Configuration

  * Test Scores + Candidate Info

<br>
Other
<br>

  * Gmail SMTP

  * Real-Time Sync API

  * Laravel Eloquent ORM

<br>
🎯 Core Functionality
<br>

<br>
⭐ User Portal
<br>

   * 3-stage recruitment flow

   * Stage unlocking logic

   * Auto-scoring and evaluation

   * Real-time data sync

   * Fully responsive exam UI

<br>
⭐ HR Portal
<br>

   * Candidate list & filters

   * Stage 1 / Stage 2 / Stage 3 detailed scores

   * Email notification on action

   * Multi-database management

   * Confirmation alerts before status updates

<br>
⭐ Advanced Features
<br>

   * Secured API communication

   * Multi-database architecture

   * Dynamic Vue.js components

   * Expandable system design

   * Optional: Data visualization charts

<br>
⭐ Recruitment Management System
<br>

A complete multi-stage hiring platform with:<br>
✔ Three-stage evaluation
✔ Dual portals
✔ Email automation
✔ Real-time syncing
✔ Multi-database architecture

<p align="center"> <img src="https://github.com/Platane/snk/raw/output/github-contribution-grid-snake.svg" alt="snake animation" /> </p>
